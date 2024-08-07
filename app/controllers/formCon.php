<?php

namespace controllers;

class formCon
{

    public function getForm()
    {
        echo \Template::instance()->render("formular.html");
    }

    public function submitForm(\Base $base)
    {
        $form = new \models\forms();
        $form->copyfrom($base->get('POST'));
        $form->save();
        echo "hotovo";
    }

    public function school(\Base $base)
    {
        echo \Template::instance()->render("school.html");
    }

    public function getSchool(\Base $base)
    {
        $schools = new \models\school();
        $school = $schools->findone(["id=?", 1]);
        $response = [];
        if ($school) {
            $schoolData = $school->cast();
            $response = array_merge(['exists' => true], $schoolData);
        } else {
            $response = ['exists' => false, 'message' => 'School not found.'];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }


    public function submitSchool(\Base $base)
    {
        $imagesDirectory = 'images/';

        $stampPath = $this->processImage($_FILES['stamp'], $imagesDirectory, 'razitko.jpg');
        $logoPath = $this->processImage($_FILES['logo'], $imagesDirectory, 'logo.jpg');

        $forms = new \models\school();
        $form = $forms->findone(["id=?", 1]);
        $form->copyfrom('POST');
        $form->set('stamp', $stampPath);
        $form->set('logo', $logoPath);
        $form->save();

        echo "hotovo";
    }

    private function processImage($file, $directory, $newFilename)
    {
        if ($file['error'] == UPLOAD_ERR_OK) {
            $tmpName = $file['tmp_name'];
            $destination = $directory . $newFilename;

            if (move_uploaded_file($tmpName, $destination)) {
                return $destination;
            }
        }
        return '';
    }

    public function listForms(\Base $base)
    {
        $queryParam = $base->get('GET.query');
        $forms = new \models\forms();
        if (!empty($queryParam)) {
            $searchCondition = array('name LIKE ? OR surname LIKE ? OR email LIKE ? OR companyName LIKE ?',
                '%' . $queryParam . '%', '%' . $queryParam . '%', '%' . $queryParam . '%', '%' . $queryParam . '%');
            $allForms = $forms->find($searchCondition);
        } else {
            $allForms = $forms->find();
        }

        $result = [];
        foreach ($allForms as $form) {
            $result[] = $form->cast();
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }


    public function getList()
    {
        echo \Template::instance()->render("list.html");
    }

    public function getPDF(\Base $base, $params)
    {
        $id = $params['id'];
        $forms = new \models\forms();
        $form = $forms->findone(["id=?", $id]);

        if (!$form) {
            echo "Form not found.";
            return;
        }


        $formData = $form->cast();
        $html = '
<!DOCTYPE html>
<html>
<head>
    <title>Formulář PDF</title>
    <style>
    body
        {
            font-family: "DejaVu Sans", "sans-serif";
            font-size: 10px;
        }
</style>
</head>
<body>
    <img src="/formularpraxe/app/images/razitko.jpg">
    <h1>Údaje o žákovi</h1>
    <p><strong>Jméno:</strong> ' . htmlspecialchars($formData['name']) . '</p>
    <p><strong>Příjmení:</strong> ' . htmlspecialchars($formData['surname']) . '</p>
    <p><strong>Číslo občanského průkazu:</strong> ' . htmlspecialchars($formData['id_number']) . '</p>
    <p><strong>Telefon:</strong> ' . htmlspecialchars($formData['phone']) . '</p>
    <p><strong>Email:</strong> ' . htmlspecialchars($formData['email']) . '</p>
    <h1>Údaje o společnosti</h1>
    <p><strong>Název společnosti:</strong> ' . htmlspecialchars($formData['companyName']) . '</p>
    <p><strong>IČO společnosti:</strong> ' . htmlspecialchars($formData['companyICO']) . '</p>
    <p><strong>Adresa společnosti:</strong> ' . htmlspecialchars($formData['companyAddress']) . '</p>
    <p><strong>Telefon společnosti:</strong> ' . htmlspecialchars($formData['companyPhone']) . '</p>
    <h1>Údaje o zástupci</h1>
    <p><strong>Jméno zástupce společnosti:</strong> ' . htmlspecialchars($formData['companyRepresentativeName']) . '</p>
    <p><strong>Příjmení zástupce společnosti:</strong> ' . htmlspecialchars($formData['companyRepresentativeSurname']) . '</p>
    <h1>Údaje o vedoucím praxe</h1>
    <p><strong>Jméno vedoucího:</strong> ' . htmlspecialchars($formData['companyMasterName']) . '</p>
    <p><strong>Příjmení vedoucího:</strong> ' . htmlspecialchars($formData['companyMasterSurname']) . '</p>
    <p><strong>Telefon vedoucího:</strong> ' . htmlspecialchars($formData['companyMasterPhone']) . '</p>
    <h1>Údaje o praxi</h1>
    <p><strong>Aktivita:</strong> ' . htmlspecialchars($formData['Activity']) . '</p>
    <p><strong>Místo:</strong> ' . htmlspecialchars($formData['Place']) . '</p>
</body>
</html>
';



        echo $html;
/*
        $pdf = new \Dompdf\Dompdf();
        $pdf->loadHtml($html, 'UTF-8'); //113
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream('formular.pdf');
*/




    }

}