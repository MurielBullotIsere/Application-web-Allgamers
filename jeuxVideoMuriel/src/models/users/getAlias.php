<?php
/**
 * vérifier que l'alias est unique
 *
 * @param string $alias alias de l'utilisateur à rechercher.
 * @return array|null Tableau des données utilisateur si trouvé, sinon null.
 * @throws Exception Si une erreur survient lors de la préparation de la requête.
 * @throws Exception Si une erreur survient lors de l'exécution de la requête.
 */
require_once 'src/models/database/databaseConnection.php';

function getAlias(string $alias) {
    $connection = bddConnect();

    $sql = "SELECT * FROM user WHERE alias = ?";// requête préparée avec un placeholder (?)
    $statement = $connection->prepare($sql);    // prépare la requête SQL pour une exécution sécurisée.
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête : ");
    }
    $statement->bind_param("s", $alias);    // Associe la variable $inputAlias au placeholder ? dans la requête SQL.
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête : ");
        }
    $data = [];
    $result = $statement->get_result();     // Retourne un objet contenant les résultats de la requête.
    

    // les 2 lignes ci-dessous sont 2 manières différentes de coder la même chose (écriture ternaire):
    //   if($result->num_rows === 1){$data = $result->fetch_assoc();}else{$data = null}
    $data = $result->num_rows === 1 ?        $result->fetch_assoc() :             null;

    // Libération des ressources
    $result->free();
    $statement->close();
    $connection->close();

    return $data;
}