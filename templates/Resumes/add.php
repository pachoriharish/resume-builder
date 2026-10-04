<h1>Create Your Resume</h1>
<?= $this->Form->create($resume) ?>

<fieldset>
    <legend>Design</legend>
    <?= $this->Form->control('template', [
        'options' => ['classic' => 'Classic', 'modern' => 'Modern', 'minimal' => 'Minimal'],
        'default' => 'classic',
    ]) ?>
</fieldset>

<fieldset>
    <legend>Personal Info</legend>
    <?= $this->Form->control('full_name') ?>
    <?= $this->Form->control('email') ?>
    <?= $this->Form->control('phone') ?>
    <?= $this->Form->control('address') ?>
    <?= $this->Form->control('summary', ['type' => 'textarea', 'label' => 'Professional Summary']) ?>
</fieldset>

<?php
// Show at least one block, or as many as were submitted (kept if validation fails).
$expCount = max(1, count($resume->get('experiences') ?? []));
$eduCount = max(1, count($resume->get('educations') ?? []));
?>

<fieldset>
    <legend>Work Experience</legend>
    <div id="experiences">
        <?php for ($i = 0; $i < $expCount; $i++): ?>
            <div class="row-block">
                <?= $this->Form->control("experiences.$i.company") ?>
                <?= $this->Form->control("experiences.$i.job_title") ?>
                <?= $this->Form->control("experiences.$i.start_date", ['placeholder' => 'Jan 2020']) ?>
                <?= $this->Form->control("experiences.$i.end_date", ['placeholder' => 'Present']) ?>
                <?= $this->Form->control("experiences.$i.description", ['type' => 'textarea']) ?>
                <button type="button" class="remove-row">Remove</button>
            </div>
        <?php endfor; ?>
    </div>
    <button type="button" class="add-row" data-target="experiences" data-template="experience-template">
        + Add another job
    </button>
</fieldset>

<fieldset>
    <legend>Education</legend>
    <div id="educations">
        <?php for ($i = 0; $i < $eduCount; $i++): ?>
            <div class="row-block">
                <?= $this->Form->control("educations.$i.school") ?>
                <?= $this->Form->control("educations.$i.degree") ?>
                <?= $this->Form->control("educations.$i.start_year") ?>
                <?= $this->Form->control("educations.$i.end_year") ?>
                <button type="button" class="remove-row">Remove</button>
            </div>
        <?php endfor; ?>
    </div>
    <button type="button" class="add-row" data-target="educations" data-template="education-template">
        + Add another school
    </button>
</fieldset>

<fieldset>
    <legend>Skills</legend>
    <?= $this->Form->control('skills', ['type' => 'textarea', 'label' => 'Skills (separate with commas)']) ?>
</fieldset>

<?= $this->Form->button('Generate Resume') ?>
<?= $this->Form->end() ?>

<!-- Blank blocks copied by the "Add" buttons. __INDEX__ becomes a unique number. -->
<template id="experience-template">
    <div class="row-block">
        <div class="input text"><label>Company</label><input type="text" name="experiences[__INDEX__][company]"></div>
        <div class="input text"><label>Job Title</label><input type="text" name="experiences[__INDEX__][job_title]"></div>
        <div class="input text"><label>Start Date</label><input type="text" name="experiences[__INDEX__][start_date]" placeholder="Jan 2020"></div>
        <div class="input text"><label>End Date</label><input type="text" name="experiences[__INDEX__][end_date]" placeholder="Present"></div>
        <div class="input textarea"><label>Description</label><textarea name="experiences[__INDEX__][description]"></textarea></div>
        <button type="button" class="remove-row">Remove</button>
    </div>
</template>

<template id="education-template">
    <div class="row-block">
        <div class="input text"><label>School</label><input type="text" name="educations[__INDEX__][school]"></div>
        <div class="input text"><label>Degree</label><input type="text" name="educations[__INDEX__][degree]"></div>
        <div class="input text"><label>Start Year</label><input type="text" name="educations[__INDEX__][start_year]"></div>
        <div class="input text"><label>End Year</label><input type="text" name="educations[__INDEX__][end_year]"></div>
        <button type="button" class="remove-row">Remove</button>
    </div>
</template>

<script>
// "Add" buttons copy the blank template into the target container.
document.querySelectorAll('.add-row').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var container = document.getElementById(btn.dataset.target);
        var html = document.getElementById(btn.dataset.template).innerHTML;
        container.insertAdjacentHTML('beforeend', html.replaceAll('__INDEX__', Date.now()));
    });
});
// "Remove" buttons (one listener also covers rows added later).
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-row')) {
        e.target.closest('.row-block').remove();
    }
});
</script>