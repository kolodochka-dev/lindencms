<?php

namespace LindenCMS\Cms\Console\Commands;

use LindenCMS\Cms\Services\SchemaGenerator;
use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Schema;
// use Illuminate\Support\Facades\DB;

class SyncCommand extends Command
{
    protected $signature = 'lindencms:sync {--reset : Reset tables}';
    // protected $signature = 'cms:sync {--reset : Reset tables} {--clear : Drop tables that no longer have a corresponding node class}';

    protected $description = 'Synchronize LindenCMS nodes with the database';

    public function handle(SchemaGenerator $generator): int
    {
        $reset = $this->option('reset');
        // $clear = $this->option('clear');

        if (!$nodes = config('lindencms.nodes', [])) {
            $this->warn('No nodes found in config.');
            return self::FAILURE;
        }

        // WARNING "Reset"
        if ($reset) {
            $this->warn('RESET MODE ENABLED: Existing tables will be dropped and recreated!');
            $this->newLine();

            if (!$this->confirm('Are you sure you want to proceed? This will delete ALL existing data.')) {
                $this->info('Operation cancelled.');
                return self::SUCCESS;
            }
        }

        // WARNING "Clear"
        // if ($clear) {
        //     $this->warn('CLEAR MODE ENABLED: Tables without corresponding node classes will be dropped!');
        //     $this->newLine();

        //     if (!$this->confirm('Are you sure you want to proceed? This will delete some tables and their data.')) {
        //         $this->info('Operation cancelled.');
        //         return self::SUCCESS;
        //     }
        // }
        
        $this->newLine();
        $this->line('  Found ' . count($nodes) . ' node classes to sync');
        $this->sync($generator, $nodes, $reset);

        // if ($clear) {
        //     $this->clear($nodes);
        // }

        $this->newLine();
        $this->newLine();

        usleep(500 * 1000);
        $this->info('  ✓ Complete!');

        return self::SUCCESS;
    }

    private function sync(SchemaGenerator $generator, array $nodes, bool $reset = false)
    {
        $bar = $this->output->createProgressBar(count($nodes));
        $bar->start();

        foreach ($nodes as $nodeClass) {
            $node = $nodeClass::make();
            $generator->sync($node, $reset);
            $bar->advance();
        }

        $bar->finish();
    }

    // private function clear(array $nodes): void
    // {
    //     $prefix = config('lindencms.table_prefix', 'lindencms');

    //     // Get all expected table names from nodes
    //     $expectedTables = [];
    //     foreach ($nodes as $nodeClass) {
    //         $node = $nodeClass::make();
    //         $expectedTables[] = $node->context('db.schema')->tableName();
    //     }

    //     // Get all tables from database with the prefix
    //     $unlinkedTables = [];
    //     foreach (Schema::getTables() as $table) {
    //         $tableName = $table['name'];
    //         if (str_starts_with($tableName, "{$prefix}_")) {
    //             if (!in_array($tableName, $expectedTables)) {
    //                 $unlinkedTables[] = $tableName;
    //             }
    //         }
    //     }

    //     if (!$unlinkedTables) {
    //         return;
    //     }

    //     $this->newLine();
    //     $this->warn('Found ' . count($unlinkedTables) . ' table(s) for deleting:');
    //     foreach ($unlinkedTables as $table) {
    //         $this->line("   - {$table}");
    //     }

    //     $this->newLine();
    //     $this->info('Dropping tables...');

    //     DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    //     foreach ($unlinkedTables as $table) {

    //         Schema::drop($table);
    //         $this->line("   ✓ Dropped: {$table}");
    //     }

    //     DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
    //     $this->info('✓ Unlinked tables dropped successfully!');
    // }
}