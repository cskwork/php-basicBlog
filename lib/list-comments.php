<?php
/**
 * Tries to delete the specified comment
 *
 * @param PDO $pdo
 * @param integer $commentId
 * @return boolean Returns true on successful deletion
 * @throws Exception
 */
function deleteComment(PDO $pdo, $commentId)
{
    $sql = "
        DELETE FROM
            comment
        WHERE
            id = :id
    ";
    $stmt = $pdo->prepare($sql);
    if ($stmt === false)
    {
        throw new Exception('There was a problem preparing this query');
    }
    $result = $stmt->execute(
        array('id' => $commentId, )
    );
    return $result !== false;
}

?>