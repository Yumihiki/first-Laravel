<?php
require_once '../app.php';
require_once join_paths([MODEL_ROOT, 'Task.php']);
require_once join_paths([LIB_ROOT, 'Validate.php']);

$session = session('tasks');

if (!$session->verifiCsrToken()) {
    $session->set('errors', ['セッションが切れました。ページをリロードしてください！']);
    redirect('/');
}

$params = [
    'name' => requset_get('name'),
];

$errors = Validate::test(
    $rules = [
        'name' => 'required|not_number_only|max:'.($name_max_length = 255),
    ],
    $params,
    $messages = [
        'name' => [
            'required'        => 'タスク名を入力してください！',
            'not_number_only' => '数字だけのタスク名は登録できません！',
            'max'             => 'タスク名は'.$name_max_length.'文字以内で入力してください',
        ]
    ]
);

if ($erroes) {
    $session->set('errors', $errors);
} else {
    $id = Task::create($params);
}

redirect('/');