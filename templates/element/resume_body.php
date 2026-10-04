<h1><?= h($resume->full_name) ?></h1>
<div class="contact">
    <?= h($resume->email) ?> | <?= h($resume->phone) ?> | <?= h($resume->address) ?>
</div>

<?php if ($resume->summary): ?>
    <h2>Summary</h2>
    <p><?= nl2br(h($resume->summary)) ?></p>
<?php endif; ?>

<?php if ($resume->experiences): ?>
    <h2>Experience</h2>
    <?php foreach ($resume->experiences as $e): ?>
        <div class="item">
            <span class="date"><?= h($e->start_date) ?> - <?= h($e->end_date) ?></span>
            <strong><?= h($e->job_title) ?></strong>, <?= h($e->company) ?>
            <div><?= nl2br(h($e->description)) ?></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if ($resume->educations): ?>
    <h2>Education</h2>
    <?php foreach ($resume->educations as $ed): ?>
        <div class="item">
            <span class="date"><?= h($ed->start_year) ?> - <?= h($ed->end_year) ?></span>
            <strong><?= h($ed->degree) ?></strong>, <?= h($ed->school) ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if ($resume->skills): ?>
    <h2>Skills</h2>
    <p><?= h($resume->skills) ?></p>
<?php endif; ?>