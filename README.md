<h1>Módulo de boleto 2016 para Magento usando OpenBoleto e Wkhtmltopdf by Inovarti</h1>
**[powered by](http://www.inovarti.com.br)**

<img src="http://www.inovarti.com.br/osc/inovarti.png" alt="Módulo de boleto 2016 para Magento usando OpenBoleto e Wkhtmltopdf" />

O projeto Módulo de boleto 2016 para Magento é um módulo inicialmente desenvolvido para demandas de clientes, porém como ainda vemos buscas de módulo de boleto sem registro, resolvemos abri-lo

<h2>Dependencias</h2>
* Baseado no projeto OpenBoleto
* Necessita instalação da biblioteca Wkhtmltopdf no servidor Linux

<h2>Sobre o OpenBoleto</h2>

O OpenBoleto é uma biblioteca de código aberto para geração de boletos bancários, um meio de pagamento muito comum no Brasil. O foco é ser simples e ter uma arquitetura compatível com os recursos mais modernos do PHP, mais amigável com frameworks MVC. Criada em Janeiro de 2013, hoje finalmente lançamos a primeira versão estável.

Atualmente estão suportados os seguintes bancos: 

* Banco de Brasília (BRB)
* Banco do Brasil 
* Bradesco 
* Itaú 
* Santander 
* Unicred 

Você também pode ajudar adaptando a outros bancos, o processo consiste basicamente em identificar o modo pelo qual o banco gera o seu campo livre, ou seja, o campo de 20 a 44 do código de barras. Desta forma, basta implementar em uma classe observando outros atributos como código do banco. Como exemplo, veja a classe Bradesco.

link do projeto: https://garajau.com.br/projects/openboleto-geracao-de-boletos-em-php/

<h2>Agradecimentos</h2>

Agradeço aos mantenedores das bibliotecas BoletoPHP e Boleto Library PHP, principalmente à este último que explica muito bem como funciona a geração de boletos e foi de grande inspiração para a abstração do OpenBoleto. Agradeço também por toda comunidade que apoia e contribui para o projeto. E por último, mas não menos importante ao Cristiano Teles, coordenador da comunidade PHP-DF e grande e inspirador mentor com o qual tive o privilégio de aprender muitas das coisas aqui postas em prática. E ao Daniel Garajau que é o responsável do projeto de openboleto.


<h2>Funções do módulo</h2>

**Obs: O módulo foi feito do zero visando a padronização, aumento das conversões e performance.**

* 100% dentro dos padrões;
* Homologado no Magento 1.9.2.2;
* Opção para aviso ao cliente em 1 dia antes de expirar;
* Número do boleto seguindo sequencia própria (independente do Magento para facilitar sua localização basta inclui-lo no grid das ordens);
* Cancelamento automático;
* Após o boleto estar cancelado e o cliente clicar em imprimir os itens serão inclusos no carrinho de forma automática;
* Configuração de dias para expirar;
* Configuração da template de expiração;
* Configuração da template de cancelamento;
* Campos de instrução de pagamento do boleto;
* Não é necessário login para impressão do boleto;
* Impressão do boleto diretamente em PDF;


<h2>Developers Mantenedores do módulo</h2>

* Deivison Arthur
* Isaac Lopes
* Michel Brito
* Fernando Pacheco


<h2>Instalação</h2>

<img src="http://www.inovarti.com.br/osc/atencao2.png" alt="Atenção! Faça sempre backup antes de realizar qualquer modificação! E sempre teste em um ambiente de desenvolvimento!" title="Atenção! Faça sempre backup antes de realizar qualquer modificação! E sempre teste em um ambiente de desenvolvimento!" />

**Instalar usando o modgit:**

    $ cd /path/to/magento
    $ modgit init
    $ modgit add oscbrasil6 git@github.com:deivisonarthur/Inovarti_BoletoBancario_Magento_2016.git

**Instalação manual enviando os arquivos**

*Baixe a ultima versão aqui, descompacte o arquivo baixado e copie as pastas para dentro do diretório principal do Magento
*Limpe a cache em Sistema > Gerenciamento de Cache

<img src="http://www.inovarti.com.br/osc/atencao2.png" alt="Atenção! Faça sempre backup antes de realizar qualquer modificação! E sempre teste em um ambiente de desenvolvimento!" title="Atenção! Faça sempre backup antes de realizar qualquer modificação! E sempre teste em um ambiente de desenvolvimento!" />

<h2>Instalação parte 2 do WKHTMLTOPDF no servidor LINUX</h2>

O WKHTMLTOPDF é a biblioteca utilizada para impressão do boleto diretamente em PDF. Imprimir em PDF é importante para resguardar o cliente sobre um vírus que muda o código de barras do boleto.

O link que eu utilizei para instalar o WKHTMLTOPDF não esta mais disponível, então segue alguns links que encontrei na web. Cuidado com essa operação, caso aconteça algo com seu servidor é sua responsabilidade por não possuir o conhecimento necessário.

* http://xfloyd.net/blog/?p=745 (Ao olhar por alto, creio que seja esse o processo)
* http://askubuntu.com/questions/556667/how-to-install-wkhtmltopdf-0-12-1-on-ubuntu-server
* http://www.odoo.yenthevg.com/install-wkhtmltopdf-on-ubuntu/
* http://blog.hemantthorat.com/install-wkhtmltopdf-on-ubuntu-12-04/#.Vv2lIhIrLxg



<img src="http://www.inovarti.com.br/osc/atencao.png" alt="Atenção! Faça sempre backup antes de realizar qualquer modificação! E sempre teste em um ambiente de desenvolvimento!" title="Atenção! Faça sempre backup antes de realizar qualquer modificação! E sempre teste em um ambiente de desenvolvimento!" />

<h2>Visões de demostração do módulo de boleto 2016</h2>

**1 - Print da configuração do módulo no Magento**
<img src="http://f.cl.ly/items/032r1V0w042q3S0V1n0X/Image%202016-03-31%20at%206.48.38%20PM.png" title=“Print da configuração do módulo no Magento” />

**2 - Print da tela de Order com a coluna Número de Pedidos(Boleto) [Precisa adicionar essa coluna no grid]**
<img src=“http://f.cl.ly/items/0o0v3w392V2z0b053h2u/Image%202016-03-31%20at%207.05.14%20PM.png” title="Print da tela de Order com a coluna Número de Pedidos(Boleto) [Precisa adicionar essa coluna no grid]" />

**3 - Email para aviso de expiração de 1 dia**
<img src=“http://f.cl.ly/items/2A2G0038341c3U0y2v0O/Image%202016-03-31%20at%207.04.22%20PM.png” title="Email para aviso de expiração de 1 dia" />

**4 - Email para aviso de expiração de 1 dia**
<img src=“http://f.cl.ly/items/15281j0p2A3a1W0M1j2r/Image%202016-03-31%20at%207.04.46%20PM.png” title="Email para aviso de expiração de 1 dia" />

**5 - Após o cliente clicar em imprimir já com o pedido expirado ele irá adicionar os produtos no carrinho e avisará para refazer a compra, caso o cliente não refaça a compra o carrinho será abandonado (OBS: Não segue módulo de carrinho abandonado)**
<img src=“http://f.cl.ly/items/0L3G2U0f3Z2Y3o3F2J2e/Image%202016-03-31%20at%207.17.06%20PM.png” title=“Produtos adiconados no carrinho apos expiração“ />
Exemplo de um link de um boleto expirado, onde adicionará os produto no carrinho automaticamente: bit.ly/1MXcP4r

**6 - Link para impressão do boleto pelo admin**
<img src=“http://f.cl.ly/items/3I0y1M330z1N0m2W1S3a/Image%202016-03-31%20at%207.17.39%20PM.png” title="Link para impressão do boleto pelo admin" />

**7 - Geração do boleto diretamente em PDF**
<img src=“http://f.cl.ly/items/301h101A2M0S1N3M0q02/Image%202016-03-31%20at%207.18.20%20PM.png” title="Geração do boleto diretamente em PDF" />

<img src="http://www.inovarti.com.br/osc/atencao2.png" alt="Atenção! Faça sempre backup antes de realizar qualquer modificação! E sempre teste em um ambiente de desenvolvimento!" title="Atenção! Faça sempre backup antes de realizar qualquer modificação! E sempre teste em um ambiente de desenvolvimento!" />

<h1>ATENÇÃO!!!! Não prestamos suporte!</h1>

Por favor recomendo que busque informações sobre desenvolvimento de módulos para o Magento, instalação utilizando Github e busca aprofundada na configuração no Linux para uso do WKHTMLTOPDF. 

Fizemos o módulo e o mesmo encontra-se homologado em operação em alguns dos nossos clientes. 

Não temos como prestar *NENHUM TIPO DE SUPORTE!* Nosso metiê é plataformas fechadas, vide: www.inovarti.com.br

Então fica o apelo para que se aprofunde em desenvolvimento e contribua com a evolução desse e de outros módulo open source. 

*Magento não é fácil e não é para sobrinhos! Magento é mutíssimo complexo e exige diversas áreas de conhecimentos!*


<img src="http://www.inovarti.com.br/gostou.png" alt="Faça uma doação" title="Faça uma doação" />
**********************************************************************************************
Se você gostou, se foi útil para você, se fez você economizar aquela grana pois estava prestes a pagar caro por aquele módulo pago, pois não achava um solução gratuita que te atendesse e queira prestigiar o trabalho feito efetuando uma doação de qualquer valor, não vou negar e vou ficar grato, você pode fazer isso utilizando o Pagseguro no site oficial do projeto: [Site Oficial do projeto](http://onestepcheckout.com.br)
