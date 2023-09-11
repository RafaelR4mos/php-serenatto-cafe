<?php

class ProdutoRepositorio
{
  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  private function formarObjeto(array $produto): produto

  {
    return new Produto(
      $produto['id'],
      $produto['tipo'],
      $produto['nome'],
      $produto['descricao'],
      $produto['preco'],
      $produto['imagem'],
    );
  }

  public function buscarTodos(): array
  {
    $sql = "SELECT * FROM produtos ORDER BY preco";
    $stmt = $this->pdo->query($sql);
    $dadosBd = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $dadosNegocio = array_map(function ($produto) {
      return $this->formarObjeto($produto);
    }, $dadosBd);

    return $dadosNegocio;
  }

  public function buscarProduto($id)
  {
    $sql = "SELECT * FROM produtos where id = ?";
    $statement = $this->pdo->prepare($sql);
    $statement->bindValue(1, $id);
    $statement->execute();

    $dados = $statement->fetch(PDO::FETCH_ASSOC);

    return $this->formarObjeto($dados);
  }

  public function buscarOpcoesCafe()
  {
    $sql_produtos_cafe = "SELECT * FROM produtos 
                          WHERE tipo = 'café' ORDER BY preco;";
    $stmt_cafe = $this->pdo->query($sql_produtos_cafe);
    $produtosCafe = $stmt_cafe->fetchAll(PDO::FETCH_ASSOC);

    $dadosCafe = array_map(function ($cafe) {
      return $this->formarObjeto($cafe);
    }, $produtosCafe);

    return $dadosCafe;
  }

  public function buscarOpcoesAlmoco(): array
  {
    $sql_produtos_almoco = "SELECT * FROM produtos WHERE tipo = 'almoço' ORDER BY preco;";

    $stmt_almoco = $this->pdo->query($sql_produtos_almoco);
    $produtosAlmoco = $stmt_almoco->fetchAll(PDO::FETCH_ASSOC);

    $dadosAlmoco = array_map(function ($almoco) {
      return $this->formarObjeto($almoco);
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

  public function inserirProduto(Produto $produto): bool
  {
    $sql = "INSERT INTO produtos (tipo, nome, descricao, imagem, preco) VALUES(:tipo, :nome, :descricao, :imagem, :preco);";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue("tipo", $produto->getTipo());
    $stmt->bindValue("nome", $produto->getNome());
    $stmt->bindValue("descricao", $produto->getDescricao());
    $stmt->bindValue("imagem", $produto->getImagem());
    $stmt->bindValue("preco", $produto->getPreco());

    return $stmt->execute();
  }

  public function updateProduto(Produto $produto)
  {
    $sql = "UPDATE produtos set nome = :novoNome, descricao = :novoDescricao, preco = :novoPreco WHERE id = :id;";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":novoNome", $produto->getNome());
    $stmt->bindValue(":novoDescricao", $produto->getDescricao());
    $stmt->bindValue(":novoPreco", $produto->getPreco());
    $stmt->bindValue(":id", $produto->getId());
    $stmt->execute();

    if ($produto->getImagem() !== 'logo-serenatto.png') {
      $this->atualizarFoto($produto);
    }
  }

  private function atualizarFoto(Produto $produto)
  {
    $sql = "UPDATE produtos SET imagem = ? WHERE id = ?;";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(1, $produto->getImagem());
    $stmt->bindValue(2, $produto->getId());
    $stmt->execute();
  }
}
