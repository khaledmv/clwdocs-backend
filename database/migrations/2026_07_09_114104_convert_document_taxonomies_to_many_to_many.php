<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $pivots = [
        'document_type_id'    => ['document_document_type', 'document_type_id'],
        'brand_id'            => ['document_brand', 'brand_id'],
        'application_id'      => ['document_application', 'application_id'],
        'solution_id'         => ['document_solution', 'solution_id'],
        'product_category_id' => ['document_product_category', 'product_category_id'],
        'location_id'         => ['document_location', 'location_id'],
    ];

    public function up(): void
    {
        // Create pivot tables
        foreach ($this->pivots as [$tableName, $foreignColumn]) {
            Schema::create($tableName, function (Blueprint $table) use ($foreignColumn) {
                $table->foreignId('document_id')->constrained()->cascadeOnDelete();
                $table->foreignId($foreignColumn)->constrained()->cascadeOnDelete();

                $table->primary(['document_id', $foreignColumn]);
            });
        }

        // Copy existing relationships into pivot tables
        foreach ($this->pivots as $sourceColumn => [$tableName, $foreignColumn]) {
            DB::table('documents')
                ->whereNotNull($sourceColumn)
                ->select('id', $sourceColumn)
                ->orderBy('id')
                ->chunkById(200, function ($rows) use ($tableName, $foreignColumn, $sourceColumn) {
                    DB::table($tableName)->insert(
                        $rows->map(fn ($row) => [
                            'document_id' => $row->id,
                            $foreignColumn => $row->$sourceColumn,
                        ])->all()
                    );
                });
        }

        // Remove old foreign key columns
        Schema::table('documents', function (Blueprint $table) {
            foreach (array_keys($this->pivots) as $sourceColumn) {
                $table->dropConstrainedForeignId($sourceColumn);
            }
        });
    }

    public function down(): void
    {
        // Recreate original foreign key columns
        Schema::table('documents', function (Blueprint $table) {
            foreach (array_keys($this->pivots) as $sourceColumn) {
                $table->foreignId($sourceColumn)
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
            }
        });

        // Restore one relationship per document (best effort)
        foreach ($this->pivots as $sourceColumn => [$tableName, $foreignColumn]) {
            DB::table($tableName)
                ->select('document_id', $foreignColumn)
                ->orderBy('document_id')
                ->get()
                ->unique('document_id')
                ->each(function ($row) use ($sourceColumn, $foreignColumn) {
                    DB::table('documents')
                        ->where('id', $row->document_id)
                        ->update([
                            $sourceColumn => $row->$foreignColumn,
                        ]);
                });
        }

        // Drop pivot tables
        foreach ($this->pivots as [$tableName]) {
            Schema::dropIfExists($tableName);
        }
    }
};