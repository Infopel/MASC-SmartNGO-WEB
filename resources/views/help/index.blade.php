@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">

        <div class="w3-cell-row col-md-8">
            <div class="w3-cell-row align-center">
                <h4>
                    Video Aulas
                </h4>

            </div>
            <div>
                <iframe width="400" height="200" src="https://www.youtube.com/embed/NHJA3UkUYyU"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media;
                gyroscope; picture-in-picture; " class="mr-4" allowfullscreen>
                </iframe>
                <iframe width="400" height="200" src="https://www.youtube.com/embed/q6iRmwvabxo"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media;
                gyroscope; picture-in-picture" allowfullscreen>
                </iframe>


            </div>
            <div>
                <iframe width="400" height="200" src="https://www.youtube.com/embed/le4tTVOO4j4"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media;
                gyroscope; picture-in-picture" class="mr-4" allowfullscreen></iframe>

                <iframe width="400" height="200" src="https://www.youtube.com/embed/QM0ytmGIbas"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media;
                gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div>
                <iframe width="400" height="200" src="https://www.youtube.com/embed/V9J5vJwnufc"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media;
                gyroscope; picture-in-picture" class="mr-4" allowfullscreen></iframe>

                <iframe width="400" height="200" src="https://www.youtube.com/embed/cAvD2oISPGY"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media;
                gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div>
                Para ter Visializar todas as Video Aulas
                <a href="https://www.youtube.com/channel/UCLLxT8OWzx5cmkJ2YO5rEWw/videos" target="blanck">
                    <i>Clique Aqui</i>
                </a>
            </div>

        </div>


        <div class="w3-cell-row col-md-4">
            <div class="w3-cell-row">
                <h4>
                    Manuais de Utilizador
                </h4>

            </div>
            <div>
                <span  class="w3-tag w3-jumbo w3-blue w3-padding-large">
                    <i class="icon-file-pdf"></i>
                    Manual do Administrador
                </span>
                <Button href="" class="btn btn-sm m-0 btn-light border">
                 <a target="blanck" href="Manuais\Manual do Administrador_v2.pdf">Baixar</a>
                </Button>

            </div>
            <div>
                <span  class="w3-tag w3-jumbo w3-blue w3-padding-large mt-2">
                    <i class="icon-file-pdf"></i>
                    Manual do Gestor de Projectos
                </span>
                <Button class="btn btn-sm m-0 btn-light border mt-2">
                    <a  target="blanck" href="Manuais\Manual do GP_v1.pdf">Baixar</a>
                </Button>
            </div>
            <div>
                <span  class="w3-tag w3-jumbo w3-blue w3-padding-large mt-2">
                    <i class="icon-file-pdf"></i>
                    Manual de Solicitacao de Fundos
                </span>
                <Button  class="btn btn-sm m-0 btn-light border mt-2">
                    <a target="blanck" href="Manuais\Manual_SolicitacaoFundos.pdf">Baixar</a>
                </Button>
            </div>

        </div>

    </div>
@endsection
