<?php

class Produto
{
  private ?int $id;
  private string $tipo;
  private string $nome;
  private string $descricao;
  private string $imagem;
  private float $preco;

  public function __construct(?int $id, string $tipo, string $nome, string $descricao, float $preco, string $imagem = 'logo-serenatto.png')
  {
    $this->id = $id;
    $this->tipo = $tipo;
    $this->nome = $nome;
    $this->descricao = $descricao;
    $this->preco = floatval($preco);
    $this->imagem = strlen($imagem) > 3 ? $imagem : 'logo-serenatto.png';
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getTipo(): string
  {
    return $this->tipo;
  }

  public function getNome(): string
  {
    return $this->nome;
  }

  public function getDescricao(): string
  {
    return $this->descricao;
  }

  public function getImagem(): string
  {
    return $this->imagem;
  }

  public function setImagem(string $imgName): void
  {
    $this->imagem = $imgName;
  }

  public function getImagemFormatado(): string
  {
    return "img/"  . $this->imagem;
  }

  public function getPreco(): string
  {
    return number_format($this->preco, 2);
  }

  public function getPrecoFormatado(): string
  {
    return "R$ " . number_format($this->preco, 2);
  }
}
