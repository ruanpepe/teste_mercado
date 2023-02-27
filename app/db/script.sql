CREATE TABLE produtos (
    id SERIAL NOT NULL,
    nome VARCHAR (255) NOT NULL,
    preco DECIMAL NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (nome)
);

CREATE TABLE tipos (
    id SERIAL NOT NULL,
    nome VARCHAR (255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (nome)
);

CREATE TABLE produto_tipo (
    id SERIAL NOT NULL,
    id_produto INTEGER NOT NULL,
    id_tipo INTEGER NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (id_produto, id_tipo),
    CONSTRAINT fk_produto_tipo_produtos
      FOREIGN KEY (id_produto) 
	  REFERENCES produtos (id)
      ON DELETE CASCADE,
    CONSTRAINT fk_produto_tipo_tipos
      FOREIGN KEY (id_tipo) 
	  REFERENCES tipos (id)
      ON DELETE CASCADE
);

CREATE TABLE impostos (
    id SERIAL NOT NULL,
    nome VARCHAR (255) NOT NULL,
    id_tipo INTEGER NOT NULL,
    percentual DECIMAL,
    PRIMARY KEY (id),
    UNIQUE (nome),
    CONSTRAINT fk_impostos_tipos
      FOREIGN KEY (id_tipo) 
	  REFERENCES tipos (id)
      ON DELETE CASCADE
);

CREATE TABLE vendas (
    id SERIAL NOT NULL,
    horario TIMESTAMP NOT NULL,
    preco_base_produtos DECIMAL NOT NULL,
    impostos_produtos DECIMAL NOT NULL,
    valor_total DECIMAL NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE venda_produtos (
    id SERIAL NOT NULL,
    id_venda INTEGER NOT NULL,
    nome_produto VARCHAR (255) NOT NULL,
    quantidade_produto INTEGER NOT NULL,
    preco_base_produto DECIMAL NOT NULL,
    impostos_produto DECIMAL NOT NULL,
    preco_final_produto DECIMAL NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (id_venda, nome_produto),
    CONSTRAINT fk_venda_produtos_vendas
      FOREIGN KEY (id_venda) 
	  REFERENCES vendas (id)
      ON DELETE CASCADE
);