<h1>Login</h1>
<?= $this->Form->create() ?>
    <?= $this->Form->control('email', ['required' => true]) ?>
    <?= $this->Form->control('password', ['required' => true]) ?>
    <?= $this->Form->button('Login') ?>
<?= $this->Form->end() ?>
<p><?= $this->Html->link('Create an account', ['action' => 'register']) ?></p>