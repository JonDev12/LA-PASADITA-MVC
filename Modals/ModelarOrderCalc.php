<?php
require_once '../Model/Connection.php';
$con = new Connection();

function CalculateByMonth($mont_1, $mont_2, $con)
{
    try {
        // Prepare the SQL statement
        $sql = "CALL CalculateOrderMonth(?, ?)";
        $stmt = $con->getConnection()->prepare($sql);

        // Bind parameters
        $stmt->bind_param("ss", $mont_1, $mont_2);

        // Execute the statement
        if ($stmt->execute()) {
            // Fetch the result if there is any output expected
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $stmt->close();
            return
                $html = "<div class='modal fade' id='ModalCalcPd' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h1 class='modal-title fs-5' id='exampleModalLabel'>Modal title</h1>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        Total de ordenes en el mes : " . $data['total'] . "<br>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>";
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo ("Error al ejecutar el procedimiento almacenado: " . $e->getMessage());
        return false;
    }
}



if ($con->getConnection()->connect_errno) {
    echo "Failed to connect";
} else {
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $mont_1 = $_POST['countProdDate'];
        $mont_2 = $_POST['countProdDate2'];

        // Try to calculate by month
        $result = CalculateByMonth($mont_1, $mont_2, $con);
        if ($result) {
            echo "Calculation successful. Result: " . json_encode($result);
        } else {
            echo "Failed to perform calculation.";
        }
    }
}
