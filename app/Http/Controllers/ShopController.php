<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Find a product by slug, handling URL-encoded slugs from WordPress migration.
     */
    private function findProductBySlug(string $slug)
    {
        return Product::where('is_active', true)
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                  ->orWhere('slug', urlencode($slug))
                  ->orWhere('slug', rawurlencode($slug))
                  ->orWhere('slug', urldecode($slug));
            })
            ->firstOrFail();
    }

    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Sorting logic
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                // Assuming ID for now since there's no view count 
                $query->orderBy('id', 'asc');
                break;
            case 'latest':
            default:
                $query->orderByDesc('id');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        
        return view('shop.index', compact('products', 'sort'));
    }

    public function show($slug)
    {
        $product = $this->findProductBySlug($slug);
        
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->latest()
            ->limit(4)
            ->get();
            
        return view('shop.show', compact('product', 'relatedProducts'));
    }

    public function citeBibtex($slug)
    {
        $product = $this->findProductBySlug($slug);
        
        $authors = is_array($product->authors) ? implode(' and ', $product->authors) : 'Anonymous';
        $year = $product->publication_date ? $product->publication_date->format('Y') : date('Y');
        
        $bibtex = "@book{" . $product->slug . "_" . $year . ",\n";
        $bibtex .= "  author = {" . $authors . "},\n";
        $bibtex .= "  title = {" . $product->name . "},\n";
        if (is_array($product->editors) && count($product->editors) > 0) {
            $bibtex .= "  editor = {" . implode(' and ', $product->editors) . "},\n";
        }
        if (is_array($product->translators) && count($product->translators) > 0) {
            $bibtex .= "  translator = {" . implode(' and ', $product->translators) . "},\n";
        }
        if ($product->publisher_imprint) $bibtex .= "  publisher = {" . $product->publisher_imprint . "},\n";
        if ($product->publication_location) $bibtex .= "  address = {" . $product->publication_location . "},\n";
        $bibtex .= "  year = {" . $year . "},\n";
        if ($product->isbn) $bibtex .= "  isbn = {" . $product->isbn . "},\n";
        if ($product->doi) $bibtex .= "  doi = {" . $product->doi . "},\n";
        $bibtex .= "  url = {" . route('shop.show', $product->slug) . "}\n";
        $bibtex .= "}\n";

        return response($bibtex)
            ->header('Content-Type', 'application/x-bibtex')
            ->header('Content-Disposition', 'attachment; filename="' . $product->slug . '.bib"');
    }

    public function citeRis($slug)
    {
        $product = $this->findProductBySlug($slug);
        
        $year = $product->publication_date ? $product->publication_date->format('Y') : date('Y');
        
        $ris = "TY  - BOOK\n";
        if (is_array($product->authors)) {
            foreach ($product->authors as $author) {
                $ris .= "AU  - " . $author . "\n";
            }
        } else {
            $ris .= "AU  - Anonymous\n";
        }
        $ris .= "TI  - " . $product->name . "\n";
        if (is_array($product->editors) && count($product->editors) > 0) {
            foreach ($product->editors as $editor) {
                $ris .= "A2  - " . $editor . "\n";
            }
        }
        if (is_array($product->translators) && count($product->translators) > 0) {
            foreach ($product->translators as $translator) {
                $ris .= "A3  - " . $translator . "\n";
            }
        }
        $ris .= "PY  - " . $year . "\n";
        if ($product->publisher_imprint) $ris .= "PB  - " . $product->publisher_imprint . "\n";
        if ($product->publication_location) $ris .= "CY  - " . $product->publication_location . "\n";
        if ($product->isbn) $ris .= "SN  - " . $product->isbn . "\n";
        if ($product->doi) $ris .= "DO  - " . $product->doi . "\n";
        $ris .= "UR  - " . route('shop.show', $product->slug) . "\n";
        $ris .= "ER  - \n";

        return response($ris)
            ->header('Content-Type', 'application/x-research-info-systems')
            ->header('Content-Disposition', 'attachment; filename="' . $product->slug . '.ris"');
    }
}
