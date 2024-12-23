<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="views/css/styles.css">   
    <title>Mammoth's Kitchen</title>  
    
</head>
<body>
    <header>
        <?php
            include_once "views/headers/header.php";
        ?>
    </header>
    <main class="admin-main">
        <section class= "cesta">
            <h2>Administrar Web</h2>            
        </section>   
        <section class="row">     
            <aside class="menu-lateral admin-lateral col-lg-2">
                <div class="btn-group-vertical" role="group" aria-label="Vertical radio toggle button group">
                    <input type="radio" class="btn-check" data-section="productos" name="vbtn-radio" id="vbtn-radio1" autocomplete="off" checked>
                    <label class="btn btn-outline-danger" for="vbtn-radio1">Productos</label>
                    <input type="radio" class="btn-check" data-section="pedidos" name="vbtn-radio" id="vbtn-radio2" autocomplete="off">
                    <label class="btn btn-outline-danger" for="vbtn-radio2">Pedidos</label>
                    <input type="radio" class="btn-check" data-section="usuarios" name="vbtn-radio" id="vbtn-radio3" autocomplete="off">
                    <label class="btn btn-outline-danger" for="vbtn-radio3">Usuarios</label>
                    <input type="radio" class="btn-check" data-section="ofertas" name="vbtn-radio" id="vbtn-radio4" autocomplete="off">
                    <label class="btn btn-outline-danger" for="vbtn-radio4">Ofertas</label>  
                </div>
            </aside>
            <div id="content-container" class="col-lg-7">
                
            </div>
            
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm">
                                <input type="hidden" id="edit-id">
                                <div class="mb-3">
                                    <label for="edit-nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="edit-nombre">
                                </div>
                                <div class="mb-3">
                                    <label for="edit-descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="edit-descripcion"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-precio" class="form-label">Precio</label>
                                    <input type="number" class="form-control" id="edit-precio">
                                </div>
                                <div class="mb-3">
                                    <label for="edit-stock" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="edit-stock">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="saveChanges">Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            </div>            
        </section>  
    </main>
    <footer>
        <?php
            include_once "views/footer/footer.php";
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="api/main.js"></script>
</body>
</html>