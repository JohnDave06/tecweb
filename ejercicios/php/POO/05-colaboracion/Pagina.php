<?php
class Pagina {
    private $cabecera;
    private $cuerpo;
    private $pie;

    public function __construct($texto1, $texto2) {
        $this->cabecera = new Cabecera ($texto1);
        $this->cuerpo = new Cuerpo;
        $this->pie = new Pie ($texto2);
    }

    public function insertar_cuerpo($texto) {
        $this->cuerpo->insertar_parrafo($texto);
    }

    public function graficar() {
        $this->cabecera->graficar();
        $this->cuerpo->graficar();
        $this->pie->graficar();
    }
}

class Cabecera {
    private $titulo;

    public function __construct($tit) {
        $this->titulo = $tit;
    }

    public function graficar() {
        echo '<h1>'. $this->titulo .'</h1>';
    }
}

class Cuerpo {
    private $lineas;

    public function insertar_parrafo($texto) {
        $this->lineas[] = $texto;
    }   

    public function graficar() {
        for ($i=0; $i<count($this->lineas); $i++) {
            echo '<p>'. $this->lineas[$i] .'</p>';
        }
    }
}

class Pie {
    private $titulo;

    public function __construct($tit) {
        $this->titulo = $tit;
    }

    public function graficar() {
        echo '<h4>'. $this->titulo .'</h4>';
    }
}
?>