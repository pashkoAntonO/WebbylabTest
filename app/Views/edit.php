<?php include_once "layout/header.php" ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <form action="/update/<?php echo $movies["id"] ?>" method="post">

                    <div class="form-group">
                        <label for="title">Название фильма:</label>
                        <input type="text" class="form-control" name="title" required="required" placeholder="Название"
                               value="<?php echo $movies['title'] ?>" id="title">
                    </div>
                    <div class="form-group">
                        <label for="year">Год релиза(19xx - 20xx):</label>
                        <input type="text" class="form-control" pattern="[1-2][09][0-9]{2}" required="required"
                               value="<?php echo $movies['year'] ?>" name="year" id="year">
                    </div>
                    <div class="form-group">
                        <label for="format">Формат:</label>
                        <select name="format" class="form-control">
                            <option value="DVD">DVD</option>
                            <option value="VHS">VHS</option>
                            <option value="Blu-Ray">Blu-Ray</option>
                        </select>
                    </div>
                    <div class="form-group" id="star">
                        <label for="">Актеры:</label>

                        <?php foreach ($movies['stars'] as $star) { ?>
                            <br>
                            <input type="text" class="form-control"
                                   value="<?php echo $star ?>" name="stars[]" required="required"
                                   placeholder="Имя фамилия">
                            <?php
                        }
                        ?>
                        <br id="separate">
                    </div>
                    <div class="btn btn-warning btnAdd" onclick="addField()">Добавить актера</div>
                    <input type="submit" name="submit" value="Изменить фильм" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
<?php include_once "layout/footer.php" ?>