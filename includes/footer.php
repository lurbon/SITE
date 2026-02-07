    </main>
    
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Entraide Plus Iroise</h3>
                <p>Association d'entraide et de solidarité créée en 2010 pour aider les personnes isolées de notre belle commune et des environs.</p>
                <div class="social-links">
                    <a href="https://www.facebook.com/groups/1378419443105675/" target="_blank" aria-label="Facebook">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Liens rapides</h3>
                <p><a href="index.php">Accueil</a></p>
                <p><a href="notre-histoire.php">Notre histoire</a></p>
                <p><a href="nos-missions.php">Nos missions</a></p>
                <p><a href="actualites.php">Actualités</a></p>
                <p><a href="nous-rejoindre.php">Nous rejoindre</a></p>
            </div>
            
            <div class="footer-section">
                <h3>Contact</h3>
                <p><strong>Christiane Le Guen</strong></p>
                <p>Présidente</p>
                <p>📞 06.62.48.76.42</p>
                <p>✉️ <a href="mailto:contact@entraide-plus-iroise.fr">contact@entraide-plus-iroise.fr</a></p>
            </div>
            
            <div class="footer-section">
                <h3>Horaires</h3>
                <p>L'association fonctionne grâce à ses bénévoles.</p>
                <p>Pour toute demande, contactez-nous par téléphone ou via notre formulaire de contact.</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Entraide Plus Iroise - Tous droits réservés | 
            <a href="mentions-legales.php">Mentions légales</a> | 
            <a href="admin/login.php">Administration</a></p>
        </div>
    </footer>
    
    <!-- Sélecteur de thème -->
    <div id="theme-picker" style="position:fixed;bottom:30px;left:30px;z-index:9999;">
        <button id="theme-picker-btn" title="Changer le thème" style="width:42px;height:42px;border-radius:50%;border:none;background:var(--primary-color);color:#fff;cursor:pointer;box-shadow:0 2px 10px rgba(0,0,0,0.2);display:flex;align-items:center;justify-content:center;transition:transform 0.2s,background 0.2s;">
            <svg viewBox="0 0 24 24" fill="currentColor" style="width:20px;height:20px;"><path d="M12 2C6.49 2 2 6.49 2 12s4.49 10 10 10c.55 0 1-.45 1-1v-.5c0-.25.1-.48.27-.65.17-.17.4-.27.65-.27H15c3.31 0 6-2.69 6-6 0-5.17-4.03-9.58-9-9.58zM6.5 13c-.83 0-1.5-.67-1.5-1.5S5.67 10 6.5 10s1.5.67 1.5 1.5S7.33 13 6.5 13zm3-4C8.67 9 8 8.33 8 7.5S8.67 6 9.5 6s1.5.67 1.5 1.5S10.33 9 9.5 9zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 6 14.5 6s1.5.67 1.5 1.5S15.33 9 14.5 9zm3 4c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
        </button>
        <div id="theme-dropdown" style="display:none;position:absolute;bottom:52px;left:0;background:#fff;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.15);padding:10px;min-width:170px;">
            <div style="font-size:11px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;padding:0 6px;">Thème</div>
            <button class="theme-opt" data-theme="default" style="display:flex;align-items:center;gap:8px;padding:7px 8px;border:none;background:none;cursor:pointer;width:100%;border-radius:6px;font-size:13px;color:#111827;font-family:inherit;"><span style="display:flex;gap:3px;"><span style="width:14px;height:14px;border-radius:50%;background:#2563eb;border:1px solid rgba(0,0,0,0.1);display:block;"></span><span style="width:14px;height:14px;border-radius:50%;background:#10b981;border:1px solid rgba(0,0,0,0.1);display:block;"></span></span>Océan</button>
            <button class="theme-opt" data-theme="ardoise" style="display:flex;align-items:center;gap:8px;padding:7px 8px;border:none;background:none;cursor:pointer;width:100%;border-radius:6px;font-size:13px;color:#111827;font-family:inherit;"><span style="display:flex;gap:3px;"><span style="width:14px;height:14px;border-radius:50%;background:#475569;border:1px solid rgba(0,0,0,0.1);display:block;"></span><span style="width:14px;height:14px;border-radius:50%;background:#0ea5e9;border:1px solid rgba(0,0,0,0.1);display:block;"></span></span>Ardoise</button>
            <button class="theme-opt" data-theme="foret" style="display:flex;align-items:center;gap:8px;padding:7px 8px;border:none;background:none;cursor:pointer;width:100%;border-radius:6px;font-size:13px;color:#111827;font-family:inherit;"><span style="display:flex;gap:3px;"><span style="width:14px;height:14px;border-radius:50%;background:#166534;border:1px solid rgba(0,0,0,0.1);display:block;"></span><span style="width:14px;height:14px;border-radius:50%;background:#ca8a04;border:1px solid rgba(0,0,0,0.1);display:block;"></span></span>Forêt</button>
            <button class="theme-opt" data-theme="bordeaux" style="display:flex;align-items:center;gap:8px;padding:7px 8px;border:none;background:none;cursor:pointer;width:100%;border-radius:6px;font-size:13px;color:#111827;font-family:inherit;"><span style="display:flex;gap:3px;"><span style="width:14px;height:14px;border-radius:50%;background:#9f1239;border:1px solid rgba(0,0,0,0.1);display:block;"></span><span style="width:14px;height:14px;border-radius:50%;background:#d97706;border:1px solid rgba(0,0,0,0.1);display:block;"></span></span>Bordeaux</button>
            <button class="theme-opt" data-theme="marine" style="display:flex;align-items:center;gap:8px;padding:7px 8px;border:none;background:none;cursor:pointer;width:100%;border-radius:6px;font-size:13px;color:#111827;font-family:inherit;"><span style="display:flex;gap:3px;"><span style="width:14px;height:14px;border-radius:50%;background:#1e3a5f;border:1px solid rgba(0,0,0,0.1);display:block;"></span><span style="width:14px;height:14px;border-radius:50%;background:#b45309;border:1px solid rgba(0,0,0,0.1);display:block;"></span></span>Marine</button>
            <button class="theme-opt" data-theme="aubergine" style="display:flex;align-items:center;gap:8px;padding:7px 8px;border:none;background:none;cursor:pointer;width:100%;border-radius:6px;font-size:13px;color:#111827;font-family:inherit;"><span style="display:flex;gap:3px;"><span style="width:14px;height:14px;border-radius:50%;background:#6b21a8;border:1px solid rgba(0,0,0,0.1);display:block;"></span><span style="width:14px;height:14px;border-radius:50%;background:#0d9488;border:1px solid rgba(0,0,0,0.1);display:block;"></span></span>Aubergine</button>
        </div>
    </div>
    <script>
    (function(){
        var btn = document.getElementById('theme-picker-btn');
        var dd = document.getElementById('theme-dropdown');
        var opts = document.querySelectorAll('.theme-opt');
        if (!btn || !dd) return;

        // Marquer le thème actif
        var cur = localStorage.getItem('site-theme') || 'default';
        opts.forEach(function(o){
            if (o.getAttribute('data-theme') === cur) o.style.background = '#f3f4f6';
        });

        btn.addEventListener('click', function(e){
            e.stopPropagation();
            dd.style.display = dd.style.display === 'none' ? 'block' : 'none';
        });
        btn.addEventListener('mouseenter', function(){ btn.style.transform = 'scale(1.1)'; });
        btn.addEventListener('mouseleave', function(){ btn.style.transform = 'scale(1)'; });

        document.addEventListener('click', function(e){
            if (!e.target.closest('#theme-picker')) dd.style.display = 'none';
        });

        opts.forEach(function(o){
            o.addEventListener('mouseenter', function(){ o.style.background = '#f9fafb'; });
            o.addEventListener('mouseleave', function(){ o.style.background = o.getAttribute('data-theme') === (localStorage.getItem('site-theme')||'default') ? '#f3f4f6' : 'none'; });
            o.addEventListener('click', function(){
                var theme = this.getAttribute('data-theme');
                if (theme === 'default') {
                    document.documentElement.removeAttribute('data-theme');
                } else {
                    document.documentElement.setAttribute('data-theme', theme);
                }
                localStorage.setItem('site-theme', theme);
                // Mettre à jour le bouton couleur
                var colors = {'default':'#2563eb','ardoise':'#475569','foret':'#166534','bordeaux':'#9f1239','marine':'#1e3a5f','aubergine':'#6b21a8'};
                btn.style.background = colors[theme] || '#2563eb';
                // Mettre à jour l'état actif
                opts.forEach(function(x){ x.style.background = 'none'; });
                this.style.background = '#f3f4f6';
                dd.style.display = 'none';
            });
        });

        // Couleur initiale du bouton
        var colors = {'default':'#2563eb','ardoise':'#475569','foret':'#166534','bordeaux':'#9f1239','marine':'#1e3a5f','aubergine':'#6b21a8'};
        btn.style.background = colors[cur] || '#2563eb';
    })();
    </script>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
</body>
</html>
