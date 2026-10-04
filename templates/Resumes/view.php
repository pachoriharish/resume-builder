<h1>Resume ready, <?= h($resume->full_name) ?>!</h1>
<p>
    <?= $this->Html->link('Download PDF', ['action' => 'download', $resume->id]) ?> |
    <?= $this->Html->link('My resumes', ['action' => 'index']) ?> |
    <?= $this->Html->link('Create another', ['action' => 'add']) ?>
</p>