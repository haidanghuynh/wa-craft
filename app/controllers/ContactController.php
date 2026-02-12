<?php
class ContactController extends Controller
{
    public function submit(): void
    {
        $name = $this->input('name');
        $email = $this->input('email');
        $subject = $this->input('subject');
        $message = $this->input('message');

        if (empty($name) || empty($email) || empty($message)) {
            $this->jsonResponse(['error' => $this->lang === 'vi' ? 'Vui lòng điền đầy đủ thông tin' : '必要な情報をすべて入力してください'], 400);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->jsonResponse(['error' => $this->lang === 'vi' ? 'Email không hợp lệ' : 'メールアドレスが無効です'], 400);
            return;
        }

        $model = new ContactMessage();
        $model->create([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ]);

        $this->jsonResponse([
            'success' => true,
            'message' => $this->lang === 'vi' ? 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.' : 'お問い合わせありがとうございます！早急にご返信いたします。'
        ]);
    }
}
