<?php
$page_title = "Login";
include __DIR__ . '/includes/header.php';
?>
<div class="card">
  <h2>Sign in (test accounts)</h2>
  <p>Use one of the client-side test accounts below (fake authentication, no server change).</p>

  <form id="loginForm">
    <label>
      Username<br>
      <input required name="username" type="text" />
    </label>
    <div style="height:8px"></div>
    <label>
      Password<br>
      <input required name="password" type="password" />
    </label>
    <div style="height:10px"></div>
    <button type="submit">Sign in</button>
    <button id="logoutBtn" type="button" style="display:none; margin-left:12px;">Logout</button>
  </form>

  <div id="loginResult" style="margin-top:12px"></div>

  <hr style="margin-top:16px">
  <strong>Test Accounts</strong>
  <ul>
    <li>admin / password123</li>
    <li>tester / letmein</li>
  </ul>
  <p style="font-size:0.9rem;color:#94a3b8">Note: this page simulates login locally and does not change server-side endpoints.</p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  const storageKey = 'mecc_logged_in_user';
  const form = document.getElementById('loginForm');
  const result = document.getElementById('loginResult');
  const logoutBtn = document.getElementById('logoutBtn');

  function showStatus(){
    const user = localStorage.getItem(storageKey);
    if(user){
      result.innerHTML = '<div style="color:green;font-weight:700">Signed in as ' + user + '</div>';
      logoutBtn.style.display = 'inline-block';
    } else {
      result.innerHTML = '';
      logoutBtn.style.display = 'none';
    }
  }

  form.addEventListener('submit', function(e){
    e.preventDefault();
    const u = form.username.value.trim();
    const p = form.password.value;
    const accounts = {'admin':'password123','tester':'letmein'};

    if(accounts[u] && accounts[u] === p){
      localStorage.setItem(storageKey, u);
      showStatus();
    } else {
      result.innerHTML = '<div style="color:#b91c1c;font-weight:700">Invalid credentials</div>';
    }
  });

  logoutBtn.addEventListener('click', function(){
    localStorage.removeItem(storageKey);
    showStatus();
  });

  showStatus();
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>

