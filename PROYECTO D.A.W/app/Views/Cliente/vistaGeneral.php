<?php $session = \Config\Services::session(); ?>

<div class="container">
    <div class="row">

        <div class="col-12">
            <h1 align="center">¡Hola
                <?= $session->get('Nombre') ?>!
            </h1>
            <h2 align="center"></h2>
        </div>

        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Usuarios</h5>
                    <img src="https://cdn-icons-png.flaticon.com/512/33/33308.png" width="100"><br>
                    <button type="button" class="btn btn-primary" onclick="location.href='/administrador/usuario'">Ir a
                        Usuarios</button>

                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Distribuidores</h5>
                    <img src="https://cdn-icons-png.flaticon.com/512/352/352806.png" width="100"><br>
                    <button type="button" class="btn btn-primary"
                        onclick="location.href='/administrador/distribuidor'">Ir a Distribuidores</button>
                </div>
            </div>
        </div>


        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Bicicletas</h5>
                    <img src="https://images.vexels.com/media/users/3/153529/isolated/preview/7bc69f401f0d4ac00f7a08bc28fba2e2-icono-de-trazo-de-bicicleta.png"
                        width="100"><br>
                    <button type="button" class="btn btn-primary" onclick="location.href='/administrador/bicicletas'">Ir
                        a Bicicletas</button>
                </div>
            </div>
        </div>


        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Marcas</h5>
                    <img src="https://cdn-icons-png.flaticon.com/512/5627/5627089.png" width="100"><br>
                    <button type="button" class="btn btn-primary" onclick="location.href='/administrador/marca'">Ir a
                        Marcas</button>

                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Modelos</h5>
                    <img src="https://cdn-icons-png.flaticon.com/512/603/603614.png" width="100"><br>
                    <button type="button" class="btn btn-primary" onclick="location.href='/administrador/modelo'">Ir a
                        Modelos</button>

                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Características</h5>
                    <img src="https://cdn-icons-png.flaticon.com/512/6593/6593191.png" width="100"><br>
                    <button type="button" class="btn btn-primary"
                        onclick="location.href='/administrador/caracteristicas'">Ir a Características</button>
                </div>
            </div>
        </div>


        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Componentes</h5>
                    <img src="https://cdn-icons-png.flaticon.com/512/4205/4205637.png" width="100"><br>
                    <button type="button" class="btn btn-primary"
                        onclick="location.href='/administrador/componentes'">Componentes</button>
                </div>
            </div>
        </div>

    </div>
</div>