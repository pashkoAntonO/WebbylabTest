<?php include_once "layout/header.php" ?>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <form action="upload" method="post" enctype="multipart/form-data">
                            <span class="btn btn-primary btn-file col-md-12 upload">
                             Выбрать файл <input type="file" name="filename">
                            </span>

                    <input type="submit" class="btn btn-success col-md-12" value="Загрузить"><br>
                </form>
            </div>

            <div class="col-md-8">
                <form id="search-form" action="/searchTitle" method="POST">
                    <div class="form-group col-md-8">
                        <input id="search" type="text" class="form-control" name="searchTitle"
                               placeholder="Поиск по названию">
                    </div>
                    <div class="col-md-4">
                        <input type="submit" class="btn btn-success col-md-12" value="Найти">
                    </div>

                </form>
            </div>
            <div class="col-md-8">
                <form id="search-form" action="/searchStars" method="POST">
                    <div class="form-group col-md-8">
                        <input id="search" type="text" class="form-control searchBox" name="searchStars"
                               placeholder="Поиск по актеру">
                    </div>
                    <div class="col-md-4">
                        <input type="submit" class="btn btn-success col-md-12" value="Найти">
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php if (isset($_SESSION["create"])) { ?>
    <div class="alert alert-success" role="alert" id="message">Фильм добавлен</div>
    <?php
    unset($_SESSION["create"]);
} else if (isset($_SESSION["edit"])) {
    ?>
    <div class="alert alert-success" role="alert" id="message">Фильм изменен</div>
    <?php
    unset($_SESSION["edit"]);
}
?>
    <div id="wrapper">
        <div id="messages"></div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th width="10%">ID</th>
                <th width="20%">Название <a href="/sort" class="sort glyphicon glyphicon-sort-by-alphabet"></a></th>
                <th width="10%">Год</th>
                <th width="10%">Формат</th>
                <th width="30%">Актеры</th>
                <th width="20%">Управление</th>
            </tr>
            </thead>
            <br>
            <?php foreach ($movies as $movie) { ?>
                <tr>
                    <th> <?php echo $movie["id"] ?></th>
                    <th><?php echo $movie["title"] ?></th>
                    <td><?php echo $movie["year"] ?></td>
                    <td><?php echo $movie["format"] ?></td>
                    <td><?php echo $movie["stars"] ?></td>
                    <td><a href="/edit/<?php echo $movie["id"] ?>" class="btn btn-primary">Редактировать</a>
                        <a href="/delete/<?php echo $movie["id"] ?>" class="btn btn-danger">Удалить</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php include_once "layout/footer.php" ?>