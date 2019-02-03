<?php
if(isset($_SESSION['timeout'])){
    
    
    if( !isset($_SESSION['panier'])){
		$_SESSION['panier']=array();
		$_SESSION['panier']['id_product'] = array();
		$_SESSION['panier']['quantity']= array();
		$_SESSION['panier']['product_price']=array();
    };
    $_SESSION['verrou'] = false;
    if ($_SESSION['timeout'] + 5 * 60 < time()) {
        session_unset(); 
    }
} else {
    $_SESSION['verrou'] = true;
}
?>

<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/layout.css') }}" />
    <!-- Header -->
    @section('navbar')
    <header>
            <nav>
                <ul>
                    <li><a class="white" href="http://127.0.0.1:8000/">Accueil</a></li>
                    <li><a class="white" href="http://127.0.0.1:8000/event">événement</a></li>
                    <li><a class="white" href="http://127.0.0.1:8000/shop">Boutique</a></li>
                    <li><a class="white" href="http://127.0.0.1:8000/ideabox">Boite à idée</a></li>
                    <?php if(isset($_SESSION['decoded'])){if($_SESSION['decoded']->id_status_user==2){
                        echo "<li><a href='http://127.0.0.1:8000/Administration'>Admin</a></li>";
                    }}?>
                    <li id="connexion">
                    <?php if(isset($_SESSION['decoded'])){
                            echo"<a class='white' href='http://127.0.0.1:8000/profile'>".$_SESSION['decoded']->first_name."</a>";
                        } else{
                            echo"<a class='white' href='http://127.0.0.1:8000/connection'>Connection</a>";}?></li>
                    <li>
                    <a class="white" href="http://127.0.0.1:8000/logout"id="Out">X</a></li>
                </ul>
            </nav>
    </header>
    @show
    <div class="container">
        @yield('content')
    </div>
    @section('footer')
    <footer>
        <p>&copy; Groupe4</p>
        <button class="button_mentions" onclick="location.href = 'http://localhost:8000/legalnotice';"> Mentions légales</button>
    </footer>
    @show