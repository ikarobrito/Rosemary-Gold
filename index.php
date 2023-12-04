<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https: //fonts.googleapis.com/css2?family= Cinzel:wght@400;500 ; 600 & display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/swiper-bundle.min.css">
        <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta charset="UTF-8"/> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rosemary Gold | Home </title>
        <script>
            function link(){
                window.location = "./index.html"
            }
        </script>
        
    </head>
    <body>
 <!--início menu-->   
 <div class="fundo">
        <div class="fundo_top">
            <div class="logo">
                <img src="./img/logo4.png" alt="logo" class="logo1" height="100" width="220">
            </div>
            <div class="topo"></div>
        </div>
        <div class="menu">
            <ul class="menu-h">
                <li><a href="index.php">Home</a></li>
                <li><a href="feminino.php"> Feminino</a></li>
                <li><a href="masculino.php"> Masculino</a></li>
                <li><a href="unissex.php"> Unissex</a></li>
                <li><a href="infantil.php"> Infantil</a></li>
                <li><a href="sobre.php"> Sobre</a></li>
                <li><a href="perfil.php"> Perfil</a></li>
                <li><a href="https://linktr.ee/rosemarygold"> Contato</a></li>
            </ul>
        </div> 

        <form action="pesquisa.php" method="post" autocomplete="off">
            <input type="text" id="txtBusca" name="pesquisar" class="search-box" placeholder="O que procura?" method="post">
            <button class="search-btn search-txt" id="pesquisa" type="submit"></button>
            <img src="img/lupa.png" alt="lupa" height="20" width="20">
        </form>
        

        <div class="icon">
            <a href="carrinho.php"> <img src="img/bolsa-de-compras (1).png" alt="icon" class="sacola"> </a>
        </div>

        <script>
            setTimeout(function () {
                $('#msgbox').fadeOut("slow");
            }, 3000);
        </script>

    </div>




 <!--fim menu-->   

 <!--início carrossel-->    
        <div class="slider">
        <script src="java/script.js"></script>
            <div class="slides">
                <input type="radio" name="radio-btn" id="radio1" >
                <input type="radio" name="radio-btn" id="radio2" >
                <input type="radio" name="radio-btn" id="radio3" >
                <input type="radio" name="radio-btn" id="radio4" >
                <input type="radio" name="radio-btn" id="radio5" >
    
                <div class="slide first">
                    <img src="img/slide1.jpeg" alt="img1" >
                    <link rel="stylesheet" href="#">
                </div>
    
                <div class="slide">
                    <img src="img/slide2.jpeg" alt="img2">
                    <link rel="stylesheet" href="#">
                </div>
    
                <div class="slide">
                    <img src="img/slide3.jpeg" alt="img3">
                    <link rel="stylesheet" href="#">
                </div>
    
                <div class="slide">
                    <img src="img/slide4.jpeg" alt="img4">
                    <link rel="stylesheet" href="#">
                </div>
    
                <div class="slide">
                    <img src="img/slide5.jpeg" alt="img1">
                    <link rel="stylesheet" href="#">
                </div>
    
    
                <div class="navigation-auto">
                    <div class="auto-btn1"></div>
                    <div class="auto-btn2"></div>
                    <div class="auto-btn3"></div>
                    <div class="auto-btn4"></div>
                    <div class="auto-btn5"></div>
                </div>
    
            </div>
             <div class="manual-navigation">
                <label for="radio1" class="manual-btn"></label>
                <label for="radio2" class="manual-btn"></label>
                <label for="radio3" class="manual-btn"></label>
                <label for="radio4" class="manual-btn"></label>
                <label for="radio5" class="manual-btn"></label>
            </div>
        </div>    
 <!--fim carrossel-->        
   
 <!--inicio cards carrossel-->
 <div class="slide-container swiper">
    <p class="titulo2"> <b>Confira nossos Clássicos</b> </p>
    <div class="slide-content">
        <div class="card-wrapper swiper-wrapper">
            <div class="card swiper-slide">
                <div class="image-content">
                    <span class="overlay"></span>

                    <div class="card-image">
                        <img src="img/perfumes/chanel.jpg" alt="" class="card-img">
                    </div>
                </div>

                <div class="card-content">
                    <h2 class="name">Chanel N°5</h2>
                    <p class="description">R$1.160,00</p>

                    <button class="button">Saiba mais</button>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="image-content">
                    <span class="overlay"></span>

                    <div class="card-image">
                        <img src="img/perfumes/srn.jpeg" alt="" class="card-img">
                    </div>
                </div>

                <div class="card-content">
                    <h2 class="name">Sr. N</h2>
                    <p class="description">R$ 124,90</p>

                    <button class="button">Saiba mais</button>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="image-content">
                    <span class="overlay"></span>

                    <div class="card-image">
                        <img src="img/perfumes/coffeesed.jpeg" alt="" class="card-img">
                    </div>
                </div>

                <div class="card-content">
                    <h2 class="name">Coffee Seduction</h2>
                    <p class="description">R$ 179,80</p>

                    <button class="button">Saiba mais</button>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="image-content">
                    <span class="overlay"></span>

                    <div class="card-image">
                        <img src="img/perfumes/florattared.jpeg" alt="" class="card-img">
                    </div>
                </div>

                <div class="card-content">
                    <h2 class="name">Floratta Red</h2>
                    <p class="description">R$ 139,90</p>

                    <button class="button">Saiba mais</button>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="image-content">
                    <span class="overlay"></span>

                    <div class="card-image">
                        <img src="img/perfumes/malbec.jpeg" alt="" class="card-img">
                    </div>
                </div>

                <div class="card-content">
                    <h2 class="name">Malbec</h2>
                    <p class="description">R$ 190,00</p>

                    <button class="button">Saiba mais</button>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="image-content">
                    <span class="overlay"></span>

                    <div class="card-image">
                        <img src="img/perfumes/kriskadrama.jpeg" alt="" class="card-img">
                    </div>
                </div>

                <div class="card-content">
                    <h2 class="name">Kriska Drama</h2>
                    <p class="description">R$ 129,90</p>

                    <button class="button">Saiba mais</button>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="image-content">
                    <span class="overlay"></span>

                    <div class="card-image">
                        <img src="img/perfumes/carlinhos.png" alt="" class="card-img">
                    </div>
                </div>

                <div class="card-content">
                    <h2 class="name">Carlinhos Maia</h2>
                    <p class="description">R$ 79,90</p>

                    <button class="button">Saiba mais</button>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="image-content">
                    <span class="overlay"></span>

                    <div class="card-image">
                        <img src="img/perfumes/amore.jpg" alt="" class="card-img">
                    </div>
                </div>

                <div class="card-content">
                    <h2 class="name">Amore</h2>
                    <p class="description">R$ 49,90</p>

                    <button class="button">Saiba mais</button>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="image-content">
                    <span class="overlay"></span>

                    <div class="card-image">
                        <img src="img/perfumes/ckone.jpg" alt="" class="card-img">
                    </div>
                </div>

                <div class="card-content">
                    <h2 class="name">CK One</h2>
                    <p class="description">R$ 270,90</p>

                    <button class="button">Saiba mais</button>
                </div>
            </div>
        </div>
    </div>

    <div class="swiper-button-next swiper-navBtn"></div>
    <div class="swiper-button-prev swiper-navBtn"></div>
    <div class="swiper-pagination"></div>
</div>
 <!--fim cards carrossel-->

 <!--Início marca-->
 <section>
    <p class="titulo1"> <b>Marcas </b></p>
        <div class="container2">
            <div class="card2">
               <a href=""> <img src="img/marca/chanel.png" alt="" class="card2-titulo1" width="150px" height="110px"></a>
            </div>
            <div class="card2">
                <a href=""><img src="img/marca/boticario.png" alt="" class="card2-titulo2" width="150px" height="150px"></a>
            </div>
            <div class="card2">
                <a href=""><img src="img/marca/eudora.png" alt="" class="card2-titulo3" width="150px" height="60px"></a>
            </div>
        </div>
        <div class="container2">
            <div class="card2">
                <a href=""><img src="img/marca/natura.png" alt="" class="card2-titulo4" width="110px" height="25px"></a>
            </div>
            <div class="card2">
                <a href=""><img src="img/marca/dior.png" alt="" class="card2-titulo5" width="100px" height="30px"></a>
            </div>
            <div class="card2">
               <a href=""><img src="img/marca/jequiti.png" alt="" class="card2-titulo6" width="150px" height="60px"></a>     
            </div>
        </div>
 </section>      
 <!--Fim marca--> 

<!--contato inicio-->
<section>
    <div id="contato-home">
        <div class="contato">
            <div class="card-body">
                <h1 class="card-titulo2"> Quer encontrar seu perfume perfeito?</h1>
                <p class="card-texto2">
                    Acesse ao nosso Formulário de Preferência e descubra a 
                    <br>
                    sua essência! 
                  
                </p>
                <a href="formulario.php"> <button id="conosco"> <b> Responder</b></button> </a>
            </div>
        </div>
    </div>
</section>
<!--contato fim-->

<!--inicio lista -->
                <p class="titulo4"> <b> Um pouco do que temos disponível</b> </p>
                <br>
                <p class="texto4"> Confira alguns dos conteúdos que tiveram mais acessos/ recomendações por 
                <br> parte da nossa comunidade.</p>
                <br>
                
                <div class="sla">
                <div class="cardss">
                    <div class="card-content1">
                        <h2>Melhores Fragrâncias</h2>
                        <br> 
                        <ul class="list">
                            <li> <a href="lavanda.html"> Lavandas </li> </a>
                            <li> <a href="florais.html"> Florais </li> </a>
                            <li> <a href="amadeirado.html"> Amadeirados </li> </a>
                            <li> <a href="doces.html"> Doces </li> </a>
                        </ul>
                    </div>
                </div>
            
                <div class="cardss">
                    <div class="card-content1">
                        <h2>Sugestões</h2>
                        <br> 
                        <ul class="list">
                            <li> <a href="#"> La Petite Robe Noire </li> </a>
                            <li> <a href="#"> 212 VIP Rosé </li> </a>
                            <li> <a href="#"> Floratta Red </li> </a>
                            <li> <a href="#"> Midnight Fantasy </li> </a>
                        </ul>
                    </div>
                </div>
            
                <div class="cardss">
                    <div class="card-content1">
                        <h2>Marcas</h2>
                        <br> 
                        <ul class="list">
                            <li> <a href="carolina.html"> Carolina Herrera  </li> </a>
                            <li> <a href="dior.html"> Dior </li> </a>
                            <li> <a href="pacco.html"> Pacco Rabanne </li> </a>
                            <li> <a href="chanel.html"> Chanel </li> </a>
                        </ul>
                    </div>
                </div>
                </div>
                <div class="separar"></div> 
<!--fim lista-->

<!--inicio footer-->
        <footer>
            <div class="container-footer">
                <div class="row-footer">
                    <!--footer-col inicio-->
                    <div class="footer-col">
                        <h4>Categorias</h4>
                        <ul>
                            <li> <a href="#"> Feminino</a> </li>
                            <li> <a href="#"> Masculino</a> </li>
                            <li> <a href="#"> Unissex</a> </li>
                            <li> <a href="#"> Infantil</a> </li>
                        </ul>
                    </div>
                    <!--end footer-col-->
                    <!--footer-col inicio-->
                    <div class="footer-col">
                        <h4> Ajuda</h4>
                        <ul>
                            <li> <a href="#"> Sobre nós </a> </li>
                            <li> <a href="#"> Contato</a> </li>
                            <li> <a href="#"> politica de privacidade</a> </li>
                        </ul>
                    </div>
                    <!--end footer-col-->
                    <!--footer-col inicio-->
                    <div class="footer-col">
                        <h4>Sugestões </h4>
                        <ul>
                            <li> <a href="#"> Formulário de preferência</a> </li>
                            <li> <a href="#"> Tendências</a> </li>
                            <li> <a href="#"> Mais vendidos</a> </li>
                            <li> <a href="#"> Marcas </a> </li>
                        </ul>
                    </div>
            
    
                    <div class="footer-col">
                        <h4>Redes Sociais </h4>
                        <div class="medias-socias ">
                            <ul>
                            <a href="https://www.instagram.com/rosemary_goldd/"> <i class="fa fa-instagram"></i> </a>
                            <a href="https://www.facebook.com/profile.php?id=61552037515417"> <i class="fa fa-facebook"></i> </a>
                            <a href="https://api.whatsapp.com/send?phone=5511914152486&text=Fale%20com%20a%20Rosemary%20Gold!"> <i class="fa fa-whatsapp"></i> </a>
                            </ul>
                            <p class="footer-company-name">© Copyright 2023<strong> RosemaryGold </strong>Todos os direitos reservados.</p>
                        </div>
                    </div>
                    <!--end footer-col-->
                </div>
            </div>
        </footer>
<!-- fim footer -->
    </body>
    <!-- Swiper JS -->
    <script src="java/swiper-bundle.min.js"></script>

    <!-- JavaScript -->
    <script src="java/script1.js"></script>
</html>
