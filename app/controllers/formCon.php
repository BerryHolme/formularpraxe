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

        $schools = new \models\school();
        $school = $schools->findone(["id=?", "1"]);


    }
}