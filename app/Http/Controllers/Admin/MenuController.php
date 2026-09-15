<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Render the Drag & Drop Menu Builder
    public function builder()
    {
        $menus = Menu::all();
        $currentMenu = Menu::first(); // Default to first menu
        
        if (request()->has('menu_id')) {
            $currentMenu = Menu::find(request('menu_id'));
        }

        $items = $currentMenu ? $currentMenu->items()->with('children')->get() : [];

        return view('admin.menus.builder', compact('menus', 'currentMenu', 'items'));
    }

    // Create a new Menu collection
    public function storeMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);

        $menu = Menu::create($request->all());
        return redirect()->route('admin.menus.builder', ['menu_id' => $menu->id])->with('success', 'Menu berhasil dibuat.');
    }

    // Add an item to a Menu
    public function storeItem(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'title' => 'required|string|max:255',
            'url' => 'nullable|string',
        ]);

        $order = MenuItem::where('menu_id', $request->menu_id)->max('order') + 1;

        MenuItem::create([
            'menu_id' => $request->menu_id,
            'title' => $request->title,
            'url' => $request->url ?? '#',
            'order' => $order,
        ]);

        return back()->with('success', 'Item ditambahkan ke menu.');
    }

    // Update an item details (title, url)
    public function updateItem(Request $request, $id)
    {
        $item = MenuItem::findOrFail($id);
        $item->update($request->only('title', 'url', 'target', 'icon'));
        
        return back()->with('success', 'Item diperbarui.');
    }

    // Delete an item
    public function destroyItem($id)
    {
        MenuItem::destroy($id);
        return back()->with('success', 'Item dihapus.');
    }

    // AJAX Endpoint for saving drag and drop hierarchy
    public function reorderItems(Request $request)
    {
        $menuInfo = json_decode($request->input('menu_info'), true);

        if (is_array($menuInfo)) {
            $this->updateTree($menuInfo);
        }

        return response()->json(['success' => true]);
    }

    // Recursive tree saver mapping array structure from Nestable
    private function updateTree(array $items, $parentId = null)
    {
        foreach ($items as $index => $item) {
            MenuItem::where('id', $item['id'])->update([
                'parent_id' => $parentId,
                'order' => $index,
            ]);

            if (isset($item['children']) && is_array($item['children'])) {
                $this->updateTree($item['children'], $item['id']);
            }
        }
    }
}
