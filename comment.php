<?php
    requireLogin();
    if (!isset($postId)) {
        exit();
    }
    $db = connectToDb();
    $comments = getComments($db, $postId);
?>

<details>
    <summary>Kommentarer (<?php echo count($comments); ?>)</summary>
    <form action="send-comment.php" method="post">
        <input type="hidden" name="postid" value="<?php echo $postId; ?>">
        <textarea name="comment" rows="4" required></textarea>
        <button type="submit">Kommentera</button>
    </form>

    <div>
        <?php
        $parentComments = [];
        $replies = [];

        foreach ($comments as $comment) { //Loopar igenom kommentarer och sorterar i två grupper alltså parentComments och replies.  
            if (is_null($comment['parent_comment_id'])) {
                $parentComments[] = $comment; //Blir en parent comment alltså huvudkommentar
            } else {
                $replies[$comment['parent_comment_id']][] = $comment; //BLir alltså svar till huvudkommentar.
            }
        }

        foreach ($parentComments as $comment): ?>
            <div>
                <p><strong><?php echo htmlspecialchars($comment['username']); ?></strong></p>
                <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                <small><?php echo $comment['posted_at']; ?></small>

                <details>
                    <summary>Svara</summary>
                    <form action="send-comment.php" method="post">
                        <input type="hidden" name="postid" value="<?php echo $postId; ?>">
                        <input type="hidden" name="parent_comment_id" value="<?php echo $comment['id']; ?>">
                        <textarea name="comment" rows="3" required></textarea>
                        <button type="submit">Skicka svar</button>
                    </form>
                </details>

                <?php if (!empty($replies[$comment['id']])): /*Loopar igenom alla replies om det kommentaren har fått något svar.*/ ?>
                    <?php foreach ($replies[$comment['id']] as $reply): /*Skriver ut enskilt svar på kommentaren.*/ ?>
                        <div>
                            <p><strong><?php echo htmlspecialchars($reply['username']); ?></strong></p>
                            <p><?php echo htmlspecialchars($reply['comment']); ?></p>
                            <small><?php echo $reply['posted_at']; ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <hr>
            </div>
        <?php endforeach; ?>
    </div>
</details>
