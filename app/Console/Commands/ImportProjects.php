<?php

namespace App\Console\Commands;

use App\Console\Commands\Projects\Extractor;
use App\Models\Project;
use GuzzleHttp\Promise\Each;
use Illuminate\Http\Client\Response;
use Illuminate\Console\Command;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportProjects extends Command
{
    private const CONCURRENCY_LIMIT = 4;
    private const LIST_PROJECTS_URL = 'https://planner5d.com/gallery/floorplans';
    private const PAGES_NUMBER      = 3;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-projects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table((new Project())->getTable())->truncate();

        try {
            foreach (range(1, static::PAGES_NUMBER) as $page) {
                $this->importPage($page);
            }
            return Command::SUCCESS;
        } catch (RequestException $e) {
            return Command::FAILURE;
        }
    }

    /**
     * @throws RequestException
     */
    private function importPage(int $number): void
    {
        $this->line("Import page $number");
        $response = Http::get(static::LIST_PROJECTS_URL, ['page' => $number]);
        $this->throwIfHttpError($response);

        try {
            $projectLinks = Extractor::extractProjectLinks($response->body());

            Http::pool(fn(Pool $pool) => [
                Each::ofLimit(
                    (function () use ($pool, $projectLinks) {
                        foreach ($projectLinks as $projectLink) {
                            $this->line('Import project: ' . $projectLink);

                            yield $pool->async()
                                ->get($projectLink)
                                ->then(function (Response $response) {
                                    $this->throwIfHttpError($response);
                                    try {
                                        $body       = $response->body();
                                        $title      = Extractor::extractProjectTitle($body);
                                        $canvasLink = Extractor::extractCanvasLink($body);
                                        $canvasLink = str_ireplace('viewMode=3d', 'viewMode=2d', $canvasLink);

                                        $project              = new Project();
                                        $project->title       = $title;
                                        $project->canvas_link = $canvasLink;
                                        $project->save();
                                    } catch (\Exception $exception) {
                                        $this->error($exception->getMessage());
                                    }
                                });
                        }
                    })(),
                    static::CONCURRENCY_LIMIT
                )
            ]);
        } catch (RequestException $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * @throws RequestException
     */
    private function throwIfHttpError(Response $response)
    {
        $response->throw(fn(Response $response, RequestException $e) => $this->error($response->body()));
    }
}
