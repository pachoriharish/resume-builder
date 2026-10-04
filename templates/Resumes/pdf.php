<?php
// $design is 'classic', 'modern' or 'minimal' (set by the controller)
$styles = [
    'classic' => '
        body { font-family: DejaVu Serif, serif; font-size: 12px; color: #222; }
        h1 { margin: 0; font-size: 26px; }
        h2 { border-bottom: 2px solid #333; padding-bottom: 3px; margin-top: 22px; font-size: 15px; }
        .contact { color: #555; margin-bottom: 10px; }
        .item { margin-bottom: 10px; }
        .date { float: right; color: #555; }',
    'modern' => '
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h1 { margin: 0; padding: 18px; background: #2c3e50; color: #fff; font-size: 28px; }
        .contact { background: #34495e; color: #ecf0f1; padding: 8px 18px; margin-bottom: 10px; }
        h2 { color: #2c3e50; border-left: 5px solid #3498db; padding-left: 8px; margin-top: 20px; font-size: 15px; }
        .item { margin-bottom: 10px; }
        .date { float: right; color: #3498db; }',
    'minimal' => '
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #000; }
        h1 { margin: 0; font-size: 22px; font-weight: normal; letter-spacing: 3px; text-transform: uppercase; }
        .contact { color: #666; margin-bottom: 14px; }
        h2 { margin-top: 18px; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #888; }
        .item { margin-bottom: 8px; }
        .date { float: right; color: #888; }',
];
?>
<html><head><style><?= $styles[$design] ?? $styles['classic'] ?></style></head>
<body><?= $this->element('resume_body') ?></body></html>