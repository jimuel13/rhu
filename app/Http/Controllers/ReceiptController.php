<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\PDF;
use PhpOffice\PhpWord\IOFactory;

class ReceiptController extends Controller
{

    public function generateImage()
    {
        return view('receipt');
    }


    // public function generateReceipt()
    // {
    //     // Fetch receipt data from the database (example: $receipt = Receipt::findOrFail($id))
    //     // For now, using hardcoded values for testing
    //     $customerName = 'Emerson';
    //     $date = '12-01-2000';
    //     $amount = 1000;
    //     $receiptNumber = 0000;

    //     // Load the MS Word template
    //     $templatePath = storage_path('app/public/templates/receipt.docx'); // Correct path to template
    //     $templateProcessor = new TemplateProcessor($templatePath);

    //     // Replace placeholders with values
    //     $templateProcessor->setValue('customer_name', $customerName);
    //     $templateProcessor->setValue('date', $date);
    //     $templateProcessor->setValue('amount', number_format($amount, 2));
    //     $templateProcessor->setValue('receipt_number', number_format($receiptNumber, 2));

    //     // Generate the file name
    //     $fileName = 'receipt_' . uniqid() . '.docx'; // Use uniqid for unique file names

    //     // Set the file path for saving
    //     $filePath = 'receipts/' . $fileName; // Save in 'receipts' folder

    //     // Save the filled template to the storage path
    //     $templateProcessor->saveAs(storage_path('app/public/' . $filePath));

    //     // Load the Word document after saving it
    //     $phpWord = IOFactory::load(storage_path('app/public/' . $filePath));

    //     // Save the Word content to HTML (you can manipulate it if needed)
    //     $html = $this->wordToHtml($phpWord);

    //     // Generate PDF from HTML
    //     $pdf = PDF::loadHTML($html);

    //     // Save or download the PDF
    //     return $pdf->download('document.pdf');
    // }

    public function generateReceipt()
{
        // Fetch receipt data from the database (example: $receipt = Receipt::findOrFail($id))

        $customerName = 'Emerson';
        $date = '12-01-2000';
        $amount = 1000;
        $receiptNumber = 0000;

        // Load the MS Word template
        $templatePath = storage_path('app/public/templates/receipt.docx'); // Correct path to template
        $templateProcessor = new TemplateProcessor($templatePath);

        // Replace placeholders with values
        $templateProcessor->setValue('customer_name', $customerName);
        $templateProcessor->setValue('date', $date);
        $templateProcessor->setValue('amount', number_format($amount, 2));
        $templateProcessor->setValue('receipt_number', number_format($receiptNumber, 2));

        // Generate the file name for the PDF
        $fileName = 'receipt_' . uniqid() . '.pdf'; // Use uniqid for unique file names

        // Set the file path for saving the PDF
        $filePath = 'receipts/' . $fileName; // Save in 'receipts' folder

        // Save the filled template to a temporary Word file
        $tempWordFile = storage_path('app/public/temp_receipt.docx');
        $templateProcessor->saveAs($tempWordFile);

        // Load the saved Word document
        $phpWord = IOFactory::load($tempWordFile);

        // Save the Word content to HTML (you can manipulate it if needed)
        $html = $this->wordToHtml($phpWord);

        // Generate PDF from HTML
        $pdf = PDF::loadHTML($html);

        // Save the generated PDF to the storage path
        $pdf->save(storage_path('app/public/' . $filePath));

        // Optionally, delete the temporary Word file after generating the PDF
        unlink($tempWordFile);

        // Return the saved PDF file to the user
        return response()->download(storage_path('app/public/' . $filePath));
    }

    private function wordToHtml($phpWord)
    {
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        $htmlFile = storage_path('app/temp.html');
        $htmlWriter->save($htmlFile);

        return file_get_contents($htmlFile);
    }


}

