<?php
$page_title = "Comments";
include __DIR__ . '/includes/header.php';

/* Read comments directly from app DB (intentionally unsanitized rendering for the lab) */
require_once __DIR__ . '/app/src/includes/db.php';

$rows = [];
if ($mysqli) {
  $res = $mysqli->query("SELECT id, user, message, created_at FROM comments ORDER BY id DESC LIMIT 50");
  if ($res) {
    while ($r = $res->fetch_assoc()) { $rows[] = $r; }
  }
}
?>
<div class="card">
  <h2>Community Comments</h2>

  <!-- Comment form (AJAX posts to the original vulnerable handler at /comment.php) -->
  <form id="commentForm" style="margin-bottom:1rem">
    <label style="display:block;margin-bottom:6px;">
      Name<br>
      <input name="user" type="text" placeholder="anon" style="padding:8px;border-radius:8px;border:1px solid #263347;background:transparent;color:var(--text);width:100%;box-sizing:border-box" />
    </label>

    <label style="display:block;margin-bottom:6px;">
      Message <br>
      <textarea name="message" rows="4" style="padding:8px;border-radius:8px;border:1px solid #263347;background:transparent;color:var(--text);width:100%;box-sizing:border-box"></textarea>
    </label>

    <div style="display:flex;gap:10px;align-items:center;margin-top:8px;">
      <button id="submitBtn" type="button" style="background:var(--accent);color:#0b1220;padding:8px 12px;border-radius:8px;border:0;font-weight:700;cursor:pointer">Post comment</button>
      <div id="notice" style="display:none; color:var(--muted);font-size:0.9rem">Posting… refreshing list…</div>
    </div>
  </form>

  <!-- Recent comments -->
  <div style="margin-top:1rem">
    <div class="card" style="background:transparent;border:0;padding:0">
      <h3 style="margin-top:0">Latest</h3>
      <ul style="list-style:none;padding:0;margin:0">
        <?php if (count($rows) === 0): ?>
          <li style="color:var(--muted);padding:0.6rem 0">No comments yet.</li>
        <?php else: ?>
          <?php foreach ($rows as $r): ?>
            <li style="padding:0.6rem 0; border-bottom:1px solid var(--border)">
              <div style="font-weight:700;color:var(--text)"><?php echo htmlspecialchars($r['user'] !== '' ? $r['user'] : 'anon'); ?></div>
              <div class="msg" style="margin-top:6px">
                <?php
                  // Intentionally render unsanitized to preserve stored XSS behavior for the lab. 
		  echo $r['message'];
                ?>
              </div>
              <?php if (!empty($r['created_at'])): ?>
                <div style="color:var(--muted); font-size:0.8rem; margin-top:6px"><?php echo htmlspecialchars($r['created_at']); ?></div>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  const form = document.getElementById('commentForm');
  const submitBtn = document.getElementById('submitBtn');
  const notice = document.getElementById('notice');

  async function postComment(data){
    const body = new URLSearchParams();
    for (const k in data) { if (Object.prototype.hasOwnProperty.call(data,k)) body.append(k, data[k]); }

    try {
      const resp = await fetch('/comment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: body.toString(),
        redirect: 'follow'
      });
      return resp.ok || resp.status === 302 || resp.status === 200;
    } catch (err) {
      console.error('POST failed', err);
      return false;
    }
  }

  submitBtn.addEventListener('click', async function(){
    const user = form.user.value || 'anon';
    const message = form.message.value || '';

    // Simple UX lock
    submitBtn.disabled = true;
    notice.style.display = 'inline-block';

    const ok = await postComment({ user, message });

    // Wait a moment for DB and logging pipelines
    setTimeout(()=> {
      // Reload the pretty page with a GET so browser won't prompt to resend POST
      window.location = window.location.pathname;
    }, 450);
  });
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>

