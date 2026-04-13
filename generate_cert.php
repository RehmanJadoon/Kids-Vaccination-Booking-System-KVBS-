<?php
session_start();

require_once 'includes/db_connection.php';
//if user is not logged in redirect to login.php page
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$booking_id = $_GET['booking_id'] ?? 0;
$user_id = $_SESSION['user_id'];
//getting data from different tables using JOIN
$certificate_query = "SELECT 
    b.id,
    b.child_id,
    b.preferred_date,
    b.preferred_time,
    c.name AS child_name,
    c.age,
    c.gender,
    u.firstname AS parent_firstname,
    u.lastname AS parent_lastname,
    u.email AS parent_email,
    v.vaccine_name,
    v.disease,
    c.user_id
FROM bookings b
JOIN children c ON b.child_id = c.id
JOIN users u ON c.user_id = u.id 
JOIN vaccines v ON b.vaccine_id = v.id
WHERE b.id = '$booking_id' AND b.status = 'Approved' AND c.user_id = '$user_id'";

$result = $connection->query($certificate_query);
$certificate_data = $result->fetch_assoc();
//error message
if (!$certificate_data) {
    die("Certificate not found or you don't have permission to access it.");
}
//TC-PDF library for generating pdf documents in php
require_once('tcpdf/tcpdf.php');
//setting page dimensions
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
//Certificate headings
$pdf->SetCreator('KidsVacc System');
$pdf->SetAuthor('KidsVacc');
$pdf->SetTitle('Child Vaccination Certificate - ' . $certificate_data['child_name']);
$pdf->SetSubject('Child Vaccination Certificate');
//setting header/ footer to none
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//this will add page
$pdf->AddPage();
//setting borders
$pdf->SetLineStyle(array('width' => 2.5, 'color' => array(13, 110, 253)));
$pdf->Rect(15, 15, 267, 180);

$pdf->SetLineStyle(array('width' => 0.5, 'color' => array(13, 110, 253)));
$pdf->Rect(20, 20, 257, 170);

$pdf->SetFont('helvetica', 'B', 28);
$pdf->SetTextColor(0, 0, 0);
$pdf->setY(35);
$pdf->Cell(0, 10, 'CHILD VACCINATION CERTIFICATE', 0, 1, 'C');
$pdf->Ln(8);

$pdf->SetFont('helvetica', '', 14);
$pdf->SetTextColor(0, 0, 0);
//certificate content
$certificate_text = "This is to certify that:\n\n";
$certificate_text .= "Booking ID: " . $certificate_data['id'] . "\n";
$certificate_text .= "Child ID: " . $certificate_data['child_id'] . " Child Name: " . $certificate_data['child_name'] . "\n";
$certificate_text .= "S/o D/o: " . $certificate_data['parent_firstname'] . " " . $certificate_data['parent_lastname'] . "\n";
$certificate_text .= "Gender: " . $certificate_data['gender'] . " | Age: " . $certificate_data['age'] . "\n\n";
$certificate_text .= "Has been successfully vaccinated with:\n";
$certificate_text .= "Vaccine: " . $certificate_data['vaccine_name'] . "\n";
$certificate_text .= "Against: " . $certificate_data['disease'] . "\n";
$certificate_text .= "On: " . date('F j, Y', strtotime($certificate_data['preferred_date'])) . "\n";
$certificate_text .= "Time: " . $certificate_data['preferred_time'] . "\n\n";
$certificate_text .= "The child is now protected from this preventable disease.";

$pdf->MultiCell(0, 10, $certificate_text, 0, 'C');
$pdf->Ln(20);

$pdf->SetTextColor(100, 100, 100);
$pdf->SetFont('helvetica', 'I', 10);
//certificate issuing auth
$pdf->Cell(0, 8, 'Issued on: ' . date('F j, Y'), 0, 1, 'C');
$pdf->Cell(0, 8, 'Issued by: KVBS System', 0, 1, 'C');
$pdf->Cell(0, 8, 'This certificate is computer generated and requires no signature.', 0, 1, 'C');

$pdf->Output('vaccination_certificate_' . $certificate_data['child_name'] . '.pdf', 'D');

$connection->close();
exit;
?>