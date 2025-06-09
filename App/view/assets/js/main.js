window.addEventListener('DOMContentLoaded', function() {

    // Esconde a mensagem após 3 segundos
    setTimeout(function() {
        const msgs = document.querySelectorAll('.sucesso, .erro');
        msgs.forEach(msg => {
            msg.style.transition = 'opacity 0.5s ease';
            msg.style.opacity = '0';
            setTimeout(() => msg.style.display = 'none', 500);
        });
    }, 3000);

    // Paginação
    const botoes = document.querySelectorAll('.paginacao .btn-pag');
    botoes.forEach(btn => {
        btn.addEventListener('click', () => {
            botoes.forEach(b => b.classList.remove('ativo'));
            btn.classList.add('ativo');
        });
    });

    // Alternar tema
    const themeToggle = document.getElementById('theme-toggle');
    const lightThemeCSS = document.getElementById('light-theme-css');
    const darkThemeCSS = document.getElementById('dark-theme-css');

    // Aplicar tema salvo
    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);

    // Alternar tema no clique
    themeToggle.addEventListener('click', () => {
        const newTheme = (localStorage.getItem('theme') === 'dark') ? 'light' : 'dark';
        localStorage.setItem('theme', newTheme);
        applyTheme(newTheme);
    });

    function applyTheme(theme) {
        if (theme === 'dark') {
            lightThemeCSS.disabled = true;
            darkThemeCSS.disabled = false;
            themeToggle.textContent = '☀️';
        } else {
            lightThemeCSS.disabled = false;
            darkThemeCSS.disabled = true;
            themeToggle.textContent = '🌙';
        }
    }
});

window.validarSenhas = function() {
    const senha = document.getElementById('senha').value;
    const confirmaSenha = document.getElementById('confirmaSenha').value;

    if (senha !== confirmaSenha) {
        alert('As senhas não coincidem. Por favor, tente novamente.');
        return false; 
    }
    return true;
};