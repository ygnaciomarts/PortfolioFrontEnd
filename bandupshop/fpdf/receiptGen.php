<?php
    include ('../config.php');

    /* incluimos primeramente el archivo que contiene la clase fpdf */

    include ('fpdf/fpdf.php');

    /* tenemos que generar una instancia de la clase */

    $pdf = new fpdf();

    $pdf->AddPage();

    /* seleccionamos el tipo, estilo y tamaño de la letra a utilizar */

    $pdf->SetFont('Helvetica', 'B', 12);

    $pdf->Image('BandUp.png', 9.5, 7, 27, 12, 'png', 'https://bandup.monkeydevs.mx/');

    $pdf->SetXY(8.9, 22);

    $pdf->Write (0, "BandUp, S.A. de C.V.","https://bandup.monkeydevs.mx/");

    $pdf->SetXY(8.9, 27);

    $pdf->SetFont('Helvetica', '', 10);

    $pdf->Write (0, utf8_decode("Blvd. Revolución y, Av. Instituto Tecnológico de La Laguna s/n"),"https://bandup.monkeydevs.mx/");

    $pdf->SetXY(8.9, 32);

    $pdf->Write (0, utf8_decode("Primero de Cobián, Centro, 27000, Torreón, Coahuila."),"https://bandup.monkeydevs.mx/");

    $pdf->SetXY(8.9, 46);

    $pdf->SetFont('Helvetica', 'B', 12);

    if(!empty($_GET['userID'])){
        $query = $link->query("SELECT * FROM usuarios WHERE id = ".$_GET['userID']);

        while($row = $query->fetch_assoc()) {
            $nombre = $row['nombre'];
            $apellido = $row['apellido'];
            $direccion = $row['direccion'];
            $email = $row['email'];
            $telefono = $row['telefono'];

    $pdf->Write (0, "Datos del cliente");

    $pdf->Ln();

    $pdf->SetXY(8.9, 50.7);

    $pdf->SetFont('Helvetica', '', 10);

    $pdf->Write(0, $nombre." ".$apellido); 

    $pdf->Ln(); //salto de linea

    $pdf->SetXY(8.9, 55);

    $pdf->Write(0, utf8_decode($direccion)); 

    $pdf->SetXY(8.9, 59.5);

    $pdf->Write(0, $email);

    $pdf->SetXY(8.9, 64.5);

    $pdf->Write(0, $telefono); 

    //$pdf->Ln(15);//ahora salta 15 lineas

    $pdf->SetXY(8.9, 78);

    $pdf->SetFont('Helvetica', 'B', 12);

    $pdf->Write(0, utf8_decode("Información de la compra")); 

    $pdf->SetFont('Helvetica', '', 10);

    $pdf->Ln(4);

    //$pdf->SetTextColor('255','0','0');//para imprimir en rojo

    if(!empty($_GET['userID'])){
        $query = $link->query("SELECT * FROM ordenes WHERE id = ".$_GET['id']);
        $pdf->SetTitle("Recibo de la orden #".$_GET['id']." - BandUp");

        while($row = $query->fetch_assoc()) {
            $total = $row['precio_total'];

                $query = $link->query("SELECT COUNT(producto_id) FROM orden_items WHERE orden_id = ".$_GET['id']);

                while($row = $query->fetch_assoc()) {
                    $count = $row['COUNT(producto_id)'];

    $pdf->Multicell(190, 6, utf8_decode(
        "Número de orden: #".$_GET['id'].
        "\nNúmero de artículos en la orden: $count
        Total de la órden: MX$".$total
    ), 1, 'R');

}

    $qr = $link->query("SELECT * FROM orden_items WHERE orden_id = ".$_GET['id']);
    
    while($row = $qr->fetch_assoc()) {
        $items = $row['producto_id'];

        $qr2 = $link->query("SELECT * FROM productos WHERE id = ".$items);
        while($row = $qr2->fetch_assoc()) {
            $idP = $row['id'];
            $nombre = $row['nombre'];
            $artista = $row['artista'];
            $tipo = $row['tipo'];

            $qr3 = $link->query("SELECT COUNT(*) FROM productos WHERE id = ".$idP);
            while($row = $qr3->fetch_assoc()) {
                $cnt = $row['COUNT(*)'];
            }

            //$pdf->SetWidths(160,30);

            $pdf->Multicell(190, 6.3, 
                utf8_decode(
                    "Nombre: ".str_replace("`", "'", $nombre).
                    "\nArtista: ".$artista.
                    "\nTipo: ".$tipo.
                    "\nCantidad: ".$cnt
                ), 1, 'L'
            );
        }
    }

    $pdf->SetFont('Helvetica', 'B', 12);

    $pdf->Multicell(190, 25, utf8_decode("¡Gracias por comprar en BandUp! :)"), 2, 'C');

    $pdf->Line(0,290,700,290); //impresión de linea

    $pdf->Output("../receipts/receipt_". $_GET['id'] .".pdf",'F');

    echo "<script language='javascript'>window.open('../receipts/receipt_".$_GET['id'].".pdf', '_self');</script>";//paral archivo pdf generado
        
    }
        }}}
    exit;
?>