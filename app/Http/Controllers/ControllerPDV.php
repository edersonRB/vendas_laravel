<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Produto;
use App\Models\Venda;
use App\Models\Produto_Venda;



class ControllerPDV extends Controller
{
    public function index()
    {
        $venda_atual = Venda::where('adicionando', '1')->first();
        if ($venda_atual) {
            $listaQtds = Produto_Venda::where('venda_id', $venda_atual->id)->get();
            return view('venda', ['listaProdutos' => Produto::all(), 'vendas' => Venda::where('adicionando', '1')->get(), 'listaQtds' => $listaQtds, 'produtosNaVenda' => $venda_atual->produtos()->get()]);
        }
        return view('venda', ['listaProdutos' => Produto::all(), 'vendas' => Venda::where('adicionando', '1')->get(), 'listaQtds' => '']);
    }

    public function historico()
    {
        return view('historico', ['vendas' => Venda::where('adicionando', '0')->get(), 'listaProdutoVendas' => Produto_Venda::all()]);
    }

    public function produtos()
    {
        return view('produtos', ['listaProdutos' => Produto::all()]);
    }

    public function sobre()
    {
        return view('sobre');
    }

    public function adicionarProduto(Request $request)
    {
        $novoProduto = new Produto;
        $novoProduto->marca = $request->marca;
        $novoProduto->nome = $request->nome;
        $novoProduto->preco = $request->preco;
        $novoProduto->save();

        return redirect('/produtos');
    }

    public function excluirProduto($id)
    {
        $novoProduto = Produto::find($id);
        $novoProduto->delete();

        return redirect('/produtos');
    }

    public function adicionarVenda()
    {
        $novaVenda = new Venda();
        $novaVenda->adicionando = 1;
        $novaVenda->total = 0;
        $novaVenda->save();

        return redirect('/home');
    }

    public function adicionarItemVenda($id_venda, Request $request)
    {
        $venda = Venda::find($id_venda);

        $id_produto = $request->produto;

        $existe = Produto_Venda::where('produto_id',$id_produto)->where('venda_id',$id_venda)->get(); 

        if(count($existe)<=0)
        {
            $venda->produtos()->attach($id_produto, ['qtd' => $request->quantidade]);
        }
        $venda->save();

        return redirect('/home');
    }

    public function excluirItemVenda($id_venda, $id_produto)
    {
        $venda = Venda::find($id_venda);
        $produto = Produto::find($id_produto);

        $venda->produtos()->detach($produto);
        $venda->save();

        return redirect('/home');
    }

    public function finalizarVenda($id_venda, Request $request)
    {
        $venda = Venda::find($id_venda);

        $venda->total = $request->total;
        $venda->adicionando = 0;

        $venda->save();

        return redirect('/home');
    }
}
