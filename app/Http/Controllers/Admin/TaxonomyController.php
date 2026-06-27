<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Brand;
use App\Models\DocumentType;
use App\Models\Location;
use App\Models\ProductCategory;
use App\Models\Solution;
use Illuminate\Http\Request;

class TaxonomyController extends Controller
{
   private static array $models = [
        'document-types'     => DocumentType::class,
        'brands'             => Brand::class,
        'applications'       => Application::class,
        'solutions'          => Solution::class,
        'product-categories' => ProductCategory::class,
        'locations'          => Location::class,
    ];

    private static array $labels = [
        'document-types'     => 'Document Types',
        'brands'             => 'Brands',
        'applications'       => 'Applications',
        'solutions'          => 'Solutions',
        'product-categories' => 'Product Categories',
        'locations'          => 'Locations',
    ];

    public function index(string $type)
    {
        $model = $this->resolveModel($type);

        $items = $model::orderBy('name')->get();

        return view($this->view($type, 'index'), [
            'type'  => $type,
            'label' => self::$labels[$type],
            'items' => $items,
        ]);
    }

    public function create(string $type)
    {
        return view($this->view($type, 'create'), [
            'type'  => $type,
            'label' => self::$labels[$type],
        ]);
    }

    public function store(Request $request, string $type)
    {
        $model = $this->resolveModel($type);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $model::create([
            'name' => $request->name,
        ]);

        // return redirect()
        //     ->route('taxonomy.index', $type)
        //     ->with('success', "{$this->label($type)} created successfully.");

        $notification = array(
                "message" => "{$this->label($type)} created successfully.",
                "alert-type" => "success"
        );

        // return redirect()->back()->with('success', 'Profile updated successfully!');
        return redirect()->route('taxonomy.index', $type)->with($notification);

            
    }

    public function edit(string $type, int $id)
    {
        $model = $this->resolveModel($type);

        $item = $model::findOrFail($id);

        return view($this->view($type, 'edit'), [
            'type'  => $type,
            'label' => self::$labels[$type],
            'item'  => $item,
        ]);
    }

    public function update(Request $request, string $type, int $id)
    {
        $model = $this->resolveModel($type);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255']
        ]);

        $item = $model::findOrFail($id);

        $item->update([
            'name' => $request->name,
            'slug' => $request->slug
        ]);

        // return redirect()
        //     ->route('taxonomy.index', $type)
        //     ->with('success', "{$this->label($type)} updated successfully.");
        
        $notification = array(
                "message" => "{$this->label($type)} updated successfully.",
                "alert-type" => "success"
        );

        // return redirect()->back()->with('success', 'Profile updated successfully!');
        return redirect()->route('taxonomy.index', $type)->with($notification);
    }

    public function destroy(string $type, int $id)
    {
        $model = $this->resolveModel($type);

        $model::findOrFail($id)->delete();

        // return redirect()
        //     ->route('taxonomy.index', $type)
        //     ->with('success', "{$this->label($type)} deleted successfully.");

           $notification = array(
                "message" => "{$this->label($type)} deleted successfully.",
                "alert-type" => "success"
        );

        // return redirect()->back()->with('success', 'Profile updated successfully!');
        return redirect()->route('taxonomy.index', $type)->with($notification);
    }

    private function resolveModel(string $type): string
    {
        abort_unless(isset(self::$models[$type]), 404);

        return self::$models[$type];
    }

    private function view(string $type, string $page): string
    {
        return "backend.taxonomy.{$type}.{$page}";
    }

    private function label(string $type): string
    {
        return self::$labels[$type];
    }
}
