<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $result = Product::paginate(20);

            return response()->json(['data' => $result]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show(int $productId)
    {
        try {
            $result = Product::where('id', $productId)->first();

            return response()->json(['data' => $result]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            $data = $request->validated();

            $filenameWithExt = $data['imagem']->getClientOriginalName();
            $filename = pathinfo($filenameWithExt)['basename'];
            $data['imagem']->storeAs('products/images', $filename);

            Product::create([
                'nome' => $data['nome'],
                'categoria' => $data['categoria'],
                'valor' => $data['valor'],
                'tem_estoque' => $data['tem_estoque'] == "yes" ? true : false,
                'imagem' => $filename,
            ]);

            return response()->json(['message' => 'Produto cadastrado com sucesso.']);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function update(ProductUpdateRequest $request, int $productId)
    {
        try {
            $data = $request->validated();

            if ($data['imagem']) {
                $filenameWithExt = $data['imagem']->getClientOriginalName();
                $filename = pathinfo($filenameWithExt)['basename'];
                $data['imagem']->storeAs('products/images', $filename);
            }

            Product::where('id', $productId)
                ->update([
                    'nome' => $data['nome'],
                    'categoria' => $data['categoria'],
                    'valor' => $data['valor'],
                    'tem_estoque' => $data['tem_estoque'] == "yes" ? true : false,
                    'imagem' => $filename,
                ]);

            return response()->json(['message' => 'Produto atualizado com sucesso.']);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function destroy(int $productId)
    {
        try {
            $product = Product::findOrFail($productId);
            Storage::delete('products/images/'.$product->imagem);

            $product->delete();

            return response()->json(['message' => 'Produto deletado com sucesso.']);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

}
