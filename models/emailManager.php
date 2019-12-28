<?php
class EmailManager {
    public function sendEmail($emailTo, $subject, $body)
    {
        $emailSender = "FROM: asmansou1337@gmail.com";
        if (mail($emailTo,$subject, $body, $emailSender))
                {
                    return true;
                }
                else {
                    throw new Exception('Something Went Wrong, Please Try Again!');
                }
    }
}

?>