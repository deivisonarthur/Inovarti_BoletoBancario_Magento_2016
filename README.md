{\rtf1\ansi\ansicpg1252\cocoartf1348\cocoasubrtf170
{\fonttbl\f0\fmodern\fcharset0 Courier;}
{\colortbl;\red255\green255\blue255;\red0\green0\blue0;}
\paperw11900\paperh16840\margl1440\margr1440\vieww16600\viewh8400\viewkind0
\deftab720
\pard\pardeftab720

\f0\fs22 \cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 <h1>M\'f3dulo de boleto 2016 para Magento usando OpenBoleto e Wkhtmltopdf by Inovarti</h1>\
**[powered by](http://www.inovarti.com.br)**\
\
<img src="http://www.inovarti.com.br/osc/inovarti.png" alt="\cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 M\'f3dulo de boleto 2016 para Magento usando OpenBoleto e Wkhtmltopdf\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 " />\
\
O projeto \cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 M\'f3dulo de boleto 2016 para Magento \'e9 um m\'f3dulo inicialmente desenvolvido para demandas de clientes, por\'e9m como ainda vemos buscas de m\'f3dulo de boleto sem registro, resolvemos abri-lo\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
\
<h2>Dependencias</h2>\
* Baseado no projeto \cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 OpenBoleto\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
* Necessita instala\'e7\'e3o da biblioteca \cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 Wkhtmltopdf no servidor Linux\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
\
<h2>Sobre o \cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 OpenBoleto \cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 </2>\
\
O OpenBoleto \'e9 uma biblioteca de c\'f3digo aberto para gera\'e7\'e3o de boletos banc\'e1rios, um meio de pagamento muito comum no Brasil. O foco \'e9 ser simples e ter uma arquitetura compat\'edvel com os recursos mais modernos do PHP, mais amig\'e1vel com frameworks MVC. Criada em Janeiro de 2013, hoje finalmente lan\'e7amos a primeira vers\'e3o est\'e1vel.\
\
Atualmente est\'e3o suportados os seguintes bancos: \
\
* Banco de Bras\'edlia (BRB)\
* Banco do Brasil \
* Bradesco \
* Ita\'fa \
* Santander \
* Unicred \
\
Voc\'ea tamb\'e9m pode ajudar adaptando a outros bancos, o processo consiste basicamente em identificar o modo pelo qual o banco gera o seu campo livre, ou seja, o campo de 20 a 44 do c\'f3digo de barras. Desta forma, basta implementar em uma classe observando outros atributos como c\'f3digo do banco. Como exemplo, veja a classe Bradesco.\
\
link do projeto: {\field{\*\fldinst{HYPERLINK "https://garajau.com.br/projects/openboleto-geracao-de-boletos-em-php/"}}{\fldrslt https://garajau.com.br/projects/openboleto-geracao-de-boletos-em-php/}}\
\
\pard\pardeftab720
\cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 <h2>Agradecimentos</h2>\expnd0\expndtw0\kerning0
\
\
Agrade\'e7o aos mantenedores das bibliotecas BoletoPHP e Boleto Library PHP, principalmente \'e0 este \'faltimo que explica muito bem como funciona a gera\'e7\'e3o de boletos e foi de grande inspira\'e7\'e3o para a abstra\'e7\'e3o do OpenBoleto. Agrade\'e7o tamb\'e9m por toda comunidade que apoia e contribui para o projeto. E por \'faltimo, mas n\'e3o menos importante ao Cristiano Teles, coordenador da comunidade PHP-DF e grande e inspirador mentor com o qual tive o privil\'e9gio de aprender muitas das coisas aqui postas em pr\'e1tica. E ao Daniel Garajau que \'e9 o respons\'e1vel do projeto de openboleto.\
\pard\pardeftab720
\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
\
<h2>Fun\'e7\'f5es do m\'f3dulo</h2>\
\
**Obs: O m\'f3dulo foi feito do zero visando a padroniza\'e7\'e3o, aumento das convers\'f5es e performance.**\
\
* 100% dentro dos padr\'f5es;\
* Homologado no Magento 1.9.2.2;\
* Op\'e7\'e3o para aviso ao cliente em 1 dia antes de expirar;\
* N\'famero do boleto seguindo sequencia pr\'f3pria (independente do Magento para facilitar sua localiza\'e7\'e3o basta inclui-lo no grid das ordens);\
* Cancelamento autom\'e1tico;\
* Ap\'f3s o boleto estar cancelado e o cliente clicar em imprimir os itens ser\'e3o inclusos no carrinho de forma autom\'e1tica;\
* Configura\'e7\'e3o de dias para expirar;\
* Configura\'e7\'e3o da template de expira\'e7\'e3o;\
\pard\pardeftab720
\cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 * Configura\'e7\'e3o da template de cancelamento;\
* Campos de instru\'e7\'e3o de pagamento do boleto;\
* N\'e3o \'e9 necess\'e1rio login para impress\'e3o do boleto;\
* Impress\'e3o do boleto diretamente em PDF;\
\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
\pard\pardeftab720
\cf2 \
\pard\pardeftab720
\cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 <h2>Developers Mantenedores do m\'f3dulo</h2>\
\
* Deivison Arthur\
\pard\pardeftab720
\cf0 \expnd0\expndtw0\kerning0
* Isaac Lopes\expnd0\expndtw0\kerning0
\
* Michel Brito\
* Fernando Pacheco\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
\
\pard\pardeftab720
\cf2 \
<h2>Instala\'e7\'e3o</h2>\
\
<img src="http://www.inovarti.com.br/osc/atencao2.png" alt="Aten\'e7\'e3o! Fa\'e7a sempre backup antes de realizar qualquer modifica\'e7\'e3o! E sempre teste em um ambiente de desenvolvimento!" title="Aten\'e7\'e3o! Fa\'e7a sempre backup antes de realizar qualquer modifica\'e7\'e3o! E sempre teste em um ambiente de desenvolvimento!" />\
\
**Instalar usando o modgit:**\
\
    $ cd /path/to/magento\
    $ modgit init\
    $ modgit add oscbrasil6 git@github.com:deivisonarthur/Inovarti_BoletoBancario_Magento_2016.git\
\
**Instala\'e7\'e3o manual enviando os arquivos**\
\
*Baixe a ultima vers\'e3o aqui, descompacte o arquivo baixado e copie as pastas para dentro do diret\'f3rio principal do Magento\
*Limpe a cache em Sistema > Gerenciamento de Cache\
\
\pard\pardeftab720
\cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 <img src="http://www.inovarti.com.br/osc/atencao2.png" alt="Aten\'e7\'e3o! Fa\'e7a sempre backup antes de realizar qualquer modifica\'e7\'e3o! E sempre teste em um ambiente de desenvolvimento!" title="Aten\'e7\'e3o! Fa\'e7a sempre backup antes de realizar qualquer modifica\'e7\'e3o! E sempre teste em um ambiente de desenvolvimento!" />\
\pard\pardeftab720
\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
\pard\pardeftab720
\cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 <h2>Instala\'e7\'e3o parte 2 do WKHTMLTOPDF no servidor LINUX</h2>\
\
O WKHTMLTOPDF \'e9 a biblioteca utilizada para impress\'e3o do boleto diretamente em PDF. Imprimir em PDF \'e9 importante para resguardar o cliente sobre um v\'edrus que muda o c\'f3digo de barras do boleto.\
\
O link que eu utilizei para instalar o \expnd0\expndtw0\kerning0
WKHTMLTOPDF n\'e3o esta mais dispon\'edvel, ent\'e3o segue alguns links que encontrei na web. Cuidado com essa opera\'e7\'e3o, caso aconte\'e7a algo com seu servidor \'e9 sua responsabilidade por n\'e3o possuir o conhecimento necess\'e1rio.\
\
* {\field{\*\fldinst{HYPERLINK "http://xfloyd.net/blog/?p=745"}}{\fldrslt http://xfloyd.net/blog/?p=745}} (Ao olhar por alto, creio que seja esse o processo)\
* {\field{\*\fldinst{HYPERLINK "http://askubuntu.com/questions/556667/how-to-install-wkhtmltopdf-0-12-1-on-ubuntu-server"}}{\fldrslt http://askubuntu.com/questions/556667/how-to-install-wkhtmltopdf-0-12-1-on-ubuntu-server}}\
* {\field{\*\fldinst{HYPERLINK "http://www.odoo.yenthevg.com/install-wkhtmltopdf-on-ubuntu/"}}{\fldrslt http://www.odoo.yenthevg.com/install-wkhtmltopdf-on-ubuntu/}}\
* {\field{\*\fldinst{HYPERLINK "http://blog.hemantthorat.com/install-wkhtmltopdf-on-ubuntu-12-04/#.Vv2lIhIrLxg"}}{\fldrslt http://blog.hemantthorat.com/install-wkhtmltopdf-on-ubuntu-12-04/#.Vv2lIhIrLxg}}\expnd0\expndtw0\kerning0
\
\pard\pardeftab720
\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
\
\
<img src="http://www.inovarti.com.br/osc/atencao.png" alt="Aten\'e7\'e3o! Fa\'e7a sempre backup antes de realizar qualquer modifica\'e7\'e3o! E sempre teste em um ambiente de desenvolvimento!" title="Aten\'e7\'e3o! Fa\'e7a sempre backup antes de realizar qualquer modifica\'e7\'e3o! E sempre teste em um ambiente de desenvolvimento!" />\
\
<h2>Vis\'f5es de demostra\'e7\'e3o do \cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 m\'f3dulo de boleto 2016\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 </h2>\
\
**1 - \cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 Print da configura\'e7\'e3o do m\'f3dulo no Magento\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 **\
<img src="{\field{\*\fldinst{HYPERLINK "http://f.cl.ly/items/032r1V0w042q3S0V1n0X/Image%202016-03-31%20at%206.48.38%20PM.png"}}{\fldrslt http://f.cl.ly/items/032r1V0w042q3S0V1n0X/Image%202016-03-31%20at%206.48.38%20PM.png}}" title=\'93Print da configura\'e7\'e3o do m\'f3dulo no Magento\'94 />\
\
\pard\pardeftab720
\cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 **2 - Print da tela de Order com a coluna N\'famero de Pedidos(Boleto) [Precisa adicionar essa coluna no grid]**\
<img src=\'93{\field{\*\fldinst{HYPERLINK "http://f.cl.ly/items/0o0v3w392V2z0b053h2u/Image%202016-03-31%20at%207.05.14%20PM.png"}}{\fldrslt http://f.cl.ly/items/0o0v3w392V2z0b053h2u/Image%202016-03-31%20at%207.05.14%20PM.png}}\'94 title="\expnd0\expndtw0\kerning0
Print da tela de Order com a coluna N\'famero de Pedidos(Boleto) [Precisa adicionar essa coluna no grid]\expnd0\expndtw0\kerning0
" />\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
\
\pard\pardeftab720
\cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 **3 - Email para aviso de expira\'e7\'e3o de 1 dia**\
<img src=\'93{\field{\*\fldinst{HYPERLINK "http://f.cl.ly/items/2A2G0038341c3U0y2v0O/Image%202016-03-31%20at%207.04.22%20PM.png"}}{\fldrslt http://f.cl.ly/items/2A2G0038341c3U0y2v0O/Image%202016-03-31%20at%207.04.22%20PM.png}}\'94 title="Email para aviso de expira\'e7\'e3o de 1 dia" />\
\
**4 - Email para aviso de expira\'e7\'e3o de 1 dia**\
<img src=\'93{\field{\*\fldinst{HYPERLINK "http://f.cl.ly/items/15281j0p2A3a1W0M1j2r/Image%202016-03-31%20at%207.04.46%20PM.png"}}{\fldrslt http://f.cl.ly/items/15281j0p2A3a1W0M1j2r/Image%202016-03-31%20at%207.04.46%20PM.png}}\'94 title="Email para aviso de expira\'e7\'e3o de 1 dia" />\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
\pard\pardeftab720
\cf2 \
\pard\pardeftab720
\cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 **5 - Ap\'f3s o cliente clicar em imprimir j\'e1 com o pedido expirado ele ir\'e1 adicionar os produtos no carrinho e avisar\'e1 para refazer a compra, caso o cliente n\'e3o refa\'e7a a compra o carrinho ser\'e1 abandonado (OBS: N\'e3o segue m\'f3dulo de carrinho abandonado)**\
<img src=\'93{\field{\*\fldinst{HYPERLINK "http://f.cl.ly/items/0L3G2U0f3Z2Y3o3F2J2e/Image%202016-03-31%20at%207.17.06%20PM.png"}}{\fldrslt http://f.cl.ly/items/0L3G2U0f3Z2Y3o3F2J2e/Image%202016-03-31%20at%207.17.06%20PM.png}}\'94 title=\'93Produtos adiconados no carrinho apos expira\'e7\'e3o\'93 />\
Exemplo de um link de um boleto expirado, onde adicionar\'e1 os produto no carrinho automaticamente: bit.ly/1MXcP4r\
\
**6 - Link para impress\'e3o do boleto pelo admin**\
<img src=\'93{\field{\*\fldinst{HYPERLINK "http://f.cl.ly/items/3I0y1M330z1N0m2W1S3a/Image%202016-03-31%20at%207.17.39%20PM.png"}}{\fldrslt http://f.cl.ly/items/3I0y1M330z1N0m2W1S3a/Image%202016-03-31%20at%207.17.39%20PM.png}}\'94 title="Link para impress\'e3o do boleto pelo admin" />\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
\pard\pardeftab720
\cf2 \
\pard\pardeftab720
\cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 **7 - Gera\'e7\'e3o do boleto diretamente em PDF**\
<img src=\'93{\field{\*\fldinst{HYPERLINK "http://f.cl.ly/items/301h101A2M0S1N3M0q02/Image%202016-03-31%20at%207.18.20%20PM.png"}}{\fldrslt \expnd0\expndtw0\kerning0
http://f.cl.ly/items/301h101A2M0S1N3M0q02/Image%202016-03-31%20at%207.18.20%20PM.png}}\'94 title="Gera\'e7\'e3o do boleto diretamente em PDF" />\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
\pard\pardeftab720
\cf2 \
<img src="http://www.inovarti.com.br/osc/atencao2.png" alt="Aten\'e7\'e3o! Fa\'e7a sempre backup antes de realizar qualquer modifica\'e7\'e3o! E sempre teste em um ambiente de desenvolvimento!" title="Aten\'e7\'e3o! Fa\'e7a sempre backup antes de realizar qualquer modifica\'e7\'e3o! E sempre teste em um ambiente de desenvolvimento!" />\
\
\pard\pardeftab720
\cf0 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 <h1>ATEN\'c7\'c3O!!!! N\'e3o prestamos suporte!</h1>\
\
Por favor recomendo que busque informa\'e7\'f5es sobre desenvolvimento de m\'f3dulos para o Magento, instala\'e7\'e3o utilizando Github e busca aprofundada na configura\'e7\'e3o no Linux para uso do WKHTMLTOPDF. \
\
Fizemos o m\'f3dulo e o mesmo encontra-se homologado em opera\'e7\'e3o em alguns dos nossos clientes. \
\
N\'e3o temos como prestar *NENHUM TIPO DE SUPORTE!* Nosso meti\'ea \'e9 plataformas fechadas, vide: www.inovarti.com.br\
\
Ent\'e3o fica o apelo para que se aprofunde em desenvolvimento e contribua com a evolu\'e7\'e3o desse e de outros m\'f3dulo open source. \
\
*Magento n\'e3o \'e9 f\'e1cil e n\'e3o \'e9 para sobrinhos! Magento \'e9 mut\'edssimo complexo e exige diversas \'e1reas de conhecimentos!*\
\pard\pardeftab720
\cf2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 \
\pard\pardeftab720
\cf2 \
<img src="http://www.inovarti.com.br/gostou.png" alt="Fa\'e7a uma doa\'e7\'e3o" title="Fa\'e7a uma doa\'e7\'e3o" />\
**********************************************************************************************\
Se voc\'ea gostou, se foi \'fatil para voc\'ea, se fez voc\'ea economizar aquela grana pois estava prestes a pagar caro por aquele m\'f3dulo pago, pois n\'e3o achava um solu\'e7\'e3o gratuita que te atendesse e queira prestigiar o trabalho feito efetuando uma doa\'e7\'e3o de qualquer valor, n\'e3o vou negar e vou ficar grato, voc\'ea pode fazer isso utilizando o Pagseguro no site oficial do projeto: [Site Oficial do projeto](http://onestepcheckout.com.br)\
}