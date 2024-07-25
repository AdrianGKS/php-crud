var app = angular.module("angularcrud", []);

app.controller("userController", function($scope, $http, $location) {
    $scope.btnName = "Cadastrar";
    $scope.user = {};

    $scope.submitForm = function() {
        if (!$scope.user.nome || !$scope.user.cpf) {
            alert("Nome e CPF são obrigatórios");
        } else {
            var formData = new FormData();
            for (var key in $scope.user) {
                formData.append(key, $scope.user[key]);
            }

            $http.post("/api/index.php?action=save", formData, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            }).then(function(response) {
                alert(response.data.message || response.data.error);
                $scope.resetForm();
                $scope.displayData();
            }, function(error) {
                alert("Erro ao salvar dados.");
                console.error(error);
            });
        }
    };

    $scope.displayData = function() {
        $http.get("/api/index.php?action=list")
            .then(function(response) {
            $scope.users = response.data;
        }, function(error) {
            alert("Erro ao carregar dados.");
            console.error(error);
        });
    };

    $scope.editUser = function(user) {
        window.location.href = 'editar.html?id=' + user.id;
    };

    $scope.deleteUser = function(id) {
        if (confirm("Deseja realmente deletar esse registro?")) {
            $http.post("/api/index.php?action=delete", { 'id' : id })
                .then(function(response) {
                    console.log(id)
                alert(response.data.message || response.data.error);
                $scope.displayData();
            }, function(error) {
                alert("Erro ao deletar dados.");
                console.error(error);
            });
        }
    };

    $scope.resetForm = function() {
        $scope.user = {};
        $scope.btnName = "Cadastrar";
    };

    $scope.generatePdf = function() {
        $http.get("/api/index.php?action=generatePdf", { responseType: 'arraybuffer' })
            .then(function(response) {
                var blob = new Blob([response.data], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "lista_pessoas.pdf";
                link.click();
            }, function(error) {
                alert("Erro ao gerar PDF.");
                console.error(error);
            });
    };

    $scope.displayData();
});

app.controller("editController", function($scope, $http, $location) {
    $scope.user = {};

    $scope.init = function() {
        var urlParams = new URLSearchParams(window.location.search);
        var id = urlParams.get('id');
        if (id) {
            $http.get("/api/index.php?action=getUser&id=" + id)
                .then(function(response) {
                $scope.user = response.data;
            }, function(error) {
                alert("Erro ao carregar dados.");
                console.error(error);
            });
        }
    };

    $scope.updateUser = function() {
        if (!$scope.user.nome || !$scope.user.cpf) {
            alert("Nome e CPF são obrigatórios");
        } else {
            var formData = new FormData();

            for (var key in $scope.user) {
                formData.append(key, $scope.user[key]);
                console.log($scope.user[key])
            }
            if ($scope.file) {
                formData.append('foto', $scope.file);
            }

            $http.post("/api/index.php?action=update", formData, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            }).then(function(response) {
                alert(response.data.message || response.data.error);
                window.location.href = 'index.html';
            }, function(error) {
                alert("Erro ao atualizar dados.");
                console.error(error);
            });
        }
    };

    $scope.cancelEdit = function() {
        window.location.href = 'index.html';
    };

    $scope.init();
});
