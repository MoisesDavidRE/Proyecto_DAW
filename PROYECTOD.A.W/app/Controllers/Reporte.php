<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
class Reporte extends BaseController
{
    public function PDF (){
        $animalModel = model('AnimalModel');
        $data['animales'] = $animalModel->findAll();
        $pdf = new Dompdf();
        $pdf->loadHTML('
        <table class="table table-stripped">
                <thead>
                    <tr>
                        <td>Número identificador</td>
                        <td>Nombre</td>
                        <td>Especie</td>
                        <td>Especificaciones</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($animales as $animal): ?>
                        <tr>
                            <td>
                                <?php echo $animal->numeroIdentificador; ?>
                            </td>
                            <td>
                                <?= $animal->nombre ?>
                            </td>
                            <td>
                                <?= $animal->especie ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        ');
        // $pdf->setPaper('A4','portrait');
        $pdf->setPaper('letter','landscape');
        $pdf->render();
        $pdf->stream();
        $pdf->stream('NombreDelArchivo.pdf',array("Attachment"=>false));//False es para que se abra en el navegador y no se descargue
                                                                        //True para que se descargue

        // ob_start();
        // $html = ob_get_clean();
        // echo $html;

        $options = $pdf->getOptions();
        $options->set(array('isRemoteEnabled'=>true));
        $pdf->setOptions($options);
        
    }
}
