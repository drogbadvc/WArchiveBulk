<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <title>Web Archive Bulk</title>
</head>
<body>
<section class="section">
    <div class="container">
        <h1 class="title">
            Web Archive Bulk
        </h1>
        <p class="subtitle">
        </p>
    </div>
    <div class="container" style="padding-top: 20px">
        <form action="" method="post">
            <div class="field">
                <label class="label">Domains</label>
                <div class="control">
                    <label>
                        <textarea class="textarea" placeholder="Textarea" name="domains"></textarea>
                    </label>
                </div>
            </div>
            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-link">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="container" style="padding-top: 20px">
        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th>Domains</th>
                <th>First Hit</th>
                <th>Last Hit</th>
                <th>Total Hits</th>
                <th>Captures</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($domains as $key => $domain) : ?>
                <tr>
                    <td><a href="https://web.archive.org/web/*/<?= $key ?>" class="button is-info"
                           target="_blank"><?= $key ?></a></td>
                    <td>
                        <a href="https://web.archive.org/web/<?= $domain['first'] ?>/<?= $key ?>" class="button"
                           target="_blank">
                        <?= $domain['first'] ? date('Y-m-d h:i:s', (strtotime($domain['first']))) : '-' ?></td>
                    <td>
                        <a href="https://web.archive.org/web/<?= $domain['last'] ?>/<?= $key ?>" class="button"
                           target="_blank">
                            <?= $domain['last'] ? date('Y-m-d h:i:s', (strtotime($domain['last']))) : '-' ?>
                        </a>
                    </td>
                    <td><a href="#" class="button is-warning"><?= $domain['total'] ?></a></td>
                    <td>
                        <div class="dropdown is-hoverable">
                            <div class="dropdown-trigger">
                                <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                                    <span><?= $domain['last'] ? date('Y', (strtotime($domain['last']))) : '-' ?></span>
                                    <span class="icon is-small">
                                 <i class="fas fa-angle-down" aria-hidden="true"></i>
                                 </span>
                                </button>
                            </div>
                            <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                <div class="dropdown-content">
                                    <?php if (!empty($domain['date'])) {
                                        foreach ($domain['date'] as $date) {
                                            $convert = date('Y', (strtotime($domain['last']))) . $date['month'] . $date['day'] ?>
                                            <a href="https://web.archive.org/web/<?= $convert ?>/<?= $key ?>"
                                               class="dropdown-item" target="_blank">
                                                <?= date('F', (strtotime($convert))) ?> <?= $date['day'] ?>
                                            </a>
                                        <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
</body>
</html>