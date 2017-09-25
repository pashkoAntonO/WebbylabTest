<?php include_once "layout/header.php" ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <form action="add" method="post">
                    <div class="form-group">
                        <label for="title">Название фильма:</label>
                        <input type="text" class="form-control" name="title" required="required" placeholder="Название"
                               id="title">
                    </div>
                    <div class="form-group">
                        <label for="year">Год релиза:</label>
                        <input type="text" class="form-control" pattern="[1-2][0-9]{3}" required="required"
                               placeholder="Год" name="year" id="year">
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
                        <input type="text" class="form-control"
                                name="stars[]" required="required" placeholder="Имя фамилия">
                        <br id="separate">
                    </div>
                    <div class="btn btn-warning addBtn" id="add" onclick="addField()">Добавить актера</div>
                    <input type="submit" name="submit" value="Создать фильм" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
<?php include_once "layout/footer.php" ?>