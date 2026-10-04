<h1>My Resumes</h1>
<p><?= $this->Html->link('+ New resume', ['action' => 'add']) ?></p>
<table>
    <tr><th>Name</th><th>Design</th><th>Created</th><th></th></tr>
    <?php foreach ($resumes as $r): ?>
    <tr>
        <td><?= h($r->full_name) ?></td>
        <td><?= h($r->template) ?></td>
        <td><?= h($r->created) ?></td>
        <td><?= $this->Html->link('Download PDF', ['action' => 'download', $r->id]) ?></td>
    </tr>
    <?php endforeach; ?>
</table>