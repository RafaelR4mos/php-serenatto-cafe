<?php

class ProdutoRepositorio
{
  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function buscarTodos()
  {
    $sql = "SELECT * FROM produtos ORDER BY preco";
    $stmt = $this->pdo->query($sql);
    $dadosBd = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $dadosNegocio = array_map(function ($produto) {
      return new Produto(
        $produto['id'],
        $produto['tipo'],
        $produto['nome'],
        $produto['descricao'],
        $produto['imagem'],
        $produto['preco']
      );
    }, $dadosBd);

    return $dadosNegocio;
  }

  public function buscarOpcoesCafe(): array
  {
    $sql_produtos_cafe = "SELECT * FROM produtos 
                          WHERE tipo = 'café' ORDER BY preco;";
    $stmt_cafe = $this->pdo->query($sql_produtos_cafe);
    $produtosCafe = $stmt_cafe->fetchAll(PDO::FETCH_ASSOC);

    $dadosCafe = array_map(function ($cafe) {
      return new Produto(
        $cafe['id'],
        $cafe['tipo'],
        $cafe['nome'],
        $cafe['descricao'],
        $cafe['imagem'],
        $cafe['preco']
      );
    }, $produtosCafe);

    return $dadosCafe;
  }

  public function buscarOpcoesAlmoco(): array
  {
    $sql_produtos_almoco = "SELECT * FROM produtos WHERE tipo = 'almoço' ORDER BY preco;";

    $stmt_almoco = $this->pdo->query($sql_produtos_almoco);
    $produtosAlmoco = $stmt_almoco->fetchAll(PDO::FETCH_ASSOC);

    $dadosAlmoco = array_map(function ($almoco) {
      return new Produto(
        $almoco['id'],
        $almoco['tipo'],
        $almoco['nome'],
        $almoco['descricao'],
        $almoco['imagem'],
        $almoco['preco']
      );
    }, $produtosAlmoco);

    return $dadosAlmoco;
  }

  public function deleteProduto($idProduto): bool
  {
    $sql = "DELETE FROM produtos where id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(1, $idProduto, PDO::PARAM_INT);

    return  $stmt->execute();
  }
}
