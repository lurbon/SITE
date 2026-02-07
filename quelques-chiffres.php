<?php
require_once 'includes/config.php';
$page_title = "Quelques chiffres";
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero" style="padding: 4rem 1rem;">
    <div class="hero-content">
        <h1>Quelques chiffres</h1>
        <p>L'impact de notre action en chiffres</p>
    </div>
</section>

<!-- Statistiques principales -->
<section class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 4rem;">
            <div style="background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); 
                        color: white; padding: 3rem 2rem; border-radius: var(--radius-xl); text-align: center; box-shadow: var(--shadow-xl);">
                <div class="counter" data-target="15" style="font-size: 4rem; font-weight: 800; margin-bottom: 0.5rem;">0</div>
                <h3 style="color: white; font-size: 1.25rem; margin: 0;">Années d'existence</h3>
                <p style="opacity: 0.9; margin-top: 0.5rem; font-size: 0.875rem;">Depuis 2010</p>
            </div>
            
            <div style="background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light)); 
                        color: white; padding: 3rem 2rem; border-radius: var(--radius-xl); text-align: center; box-shadow: var(--shadow-xl);">
                <div class="counter" data-target="90" style="font-size: 4rem; font-weight: 800; margin-bottom: 0.5rem;">0</div>
                <h3 style="color: white; font-size: 1.25rem; margin: 0;">Bénévoles</h3>
                <p style="opacity: 0.9; margin-top: 0.5rem; font-size: 0.875rem;">Toujours plus nombreux</p>
            </div>
			
              <div style="background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light)); 
                        color: white; padding: 3rem 2rem; border-radius: var(--radius-xl); text-align: center; box-shadow: var(--shadow-xl);">
                <div class="counter" data-target="300" style="font-size: 4rem; font-weight: 800; margin-bottom: 0.5rem;">0</div>
                <h3 style="color: white; font-size: 1.25rem; margin: 0;">Aidés</h3>
                <p style="opacity: 0.9; margin-top: 0.5rem; font-size: 0.875rem;">Toujours plus nombreux</p>
            </div>          
            <div style="background: linear-gradient(135deg, #f59e0b, #fbbf24); 
                        color: white; padding: 3rem 2rem; border-radius: var(--radius-xl); text-align: center; box-shadow: var(--shadow-xl);">
                <div class="counter" data-target="600" style="font-size: 4rem; font-weight: 800; margin-bottom: 0.5rem;">0</div>
                <h3 style="color: white; font-size: 1.25rem; margin: 0;">Interventions par an</h3>
                <p style="opacity: 0.9; margin-top: 0.5rem; font-size: 0.875rem;">En constante progression</p>
            </div>
            
            <div style="background: linear-gradient(135deg, #8b5cf6, #a78bfa); 
                        color: white; padding: 3rem 2rem; border-radius: var(--radius-xl); text-align: center; box-shadow: var(--shadow-xl);">
                <div class="counter" data-target="12" style="font-size: 4rem; font-weight: 800; margin-bottom: 0.5rem;">0</div>
                <h3 style="color: white; font-size: 1.25rem; margin: 0;">Communes desservies</h3>
                <p style="opacity: 0.9; margin-top: 0.5rem; font-size: 0.875rem;">Et toujours en croissance</p>
            </div>
        </div>
    </div>
</section>

<!-- Détails des interventions -->
<section class="section section-light">
    <div class="container">
        <div class="section-title">
            <h2>Nos interventions en détail</h2>
        </div>
        
        <div style="max-width: 900px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem;">
                <!-- Transport -->
                <div style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                        <div style="background: var(--primary-color); color: white; width: 60px; height: 60px; 
                                    border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                            🚗
                        </div>
                        <h3 style="color: var(--primary-color); margin: 0;">Transport</h3>
                    </div>
                    <div style="font-size: 2.5rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0.5rem;">
                        <span class="counter" data-target="400">0</span>+
                    </div>
                    <p style="color: var(--text-secondary);">Déplacements effectués par an</p>
                </div>
                
                <!-- Aide à domicile -->
                <div style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                        <div style="background: var(--secondary-color); color: white; width: 60px; height: 60px; 
                                    border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                            🏠
                        </div>
                        <h3 style="color: var(--secondary-color); margin: 0;">Aide à domicile</h3>
                    </div>
                    <div style="font-size: 2.5rem; font-weight: 700; color: var(--secondary-color); margin-bottom: 0.5rem;">
                        <span class="counter" data-target="150">0</span>+
                    </div>
                    <p style="color: var(--text-secondary);">Interventions à domicile par an</p>
                </div>
                
                <!-- Visites -->
                <div style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                        <div style="background: #f59e0b; color: white; width: 60px; height: 60px; 
                                    border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                            ❤️
                        </div>
                        <h3 style="color: #f59e0b; margin: 0;">Visites</h3>
                    </div>
                    <div style="font-size: 2.5rem; font-weight: 700; color: #f59e0b; margin-bottom: 0.5rem;">
                        <span class="counter" data-target="50">0</span>+
                    </div>
                    <p style="color: var(--text-secondary);">Visites de courtoisie mensuelles</p>
                </div>
                
                <!-- Heures de bénévolat -->
                <div style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                        <div style="background: #8b5cf6; color: white; width: 60px; height: 60px; 
                                    border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                            ⏰
                        </div>
                        <h3 style="color: #8b5cf6; margin: 0;">Temps donné</h3>
                    </div>
                    <div style="font-size: 2.5rem; font-weight: 700; color: #8b5cf6; margin-bottom: 0.5rem;">
                        <span class="counter" data-target="2000">0</span>+
                    </div>
                    <p style="color: var(--text-secondary);">Heures de bénévolat par an</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Impact social -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Notre impact social</h2>
        </div>
        
        <div style="max-width: 800px; margin: 0 auto;">
            <div style="background: white; padding: 3rem; border-radius: var(--radius-xl); box-shadow: var(--shadow-lg);">
                <div style="display: grid; gap: 2rem;">
                    <div style="display: flex; align-items: start; gap: 1.5rem;">
                        <div style="background: var(--background-light); width: 60px; height: 60px; border-radius: 50%; 
                                    flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 1.75rem;">
                            👥
                        </div>
                        <div>
                            <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">Personnes aidées</h3>
                            <p style="font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                                <span class="counter" data-target="200">0</span>+ personnes
                            </p>
                            <p style="color: var(--text-secondary);">bénéficient de nos services chaque année</p>
                        </div>
                    </div>
                    
                    <div style="height: 1px; background: var(--border-color);"></div>
                    
                    <div style="display: flex; align-items: start; gap: 1.5rem;">
                        <div style="background: var(--background-light); width: 60px; height: 60px; border-radius: 50%; 
                                    flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 1.75rem;">
                            🏘️
                        </div>
                        <div>
                            <h3 style="color: var(--secondary-color); margin-bottom: 0.5rem;">Couverture territoriale</h3>
                            <p style="font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                                <span class="counter" data-target="15000">0</span> km²
                            </p>
                            <p style="color: var(--text-secondary);">de territoire couvert par nos bénévoles</p>
                        </div>
                    </div>
                    
                    <div style="height: 1px; background: var(--border-color);"></div>
                    
                    <div style="display: flex; align-items: start; gap: 1.5rem;">
                        <div style="background: var(--background-light); width: 60px; height: 60px; border-radius: 50%; 
                                    flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 1.75rem;">
                            💪
                        </div>
                        <div>
                            <h3 style="color: #f59e0b; margin-bottom: 0.5rem;">Taux de satisfaction</h3>
                            <p style="font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                                <span class="counter" data-target="98">0</span>%
                            </p>
                            <p style="color: var(--text-secondary);">de nos bénéficiaires se disent satisfaits</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Citation -->
<section class="section section-light">
    <div class="container">
        <div style="max-width: 700px; margin: 0 auto; text-align: center;">
            <div style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;">❝</div>
            <p style="font-size: 1.5rem; line-height: 1.6; color: var(--text-primary); font-style: italic; margin-bottom: 2rem;">
                Ces chiffres représentent avant tout des histoires humaines, des sourires retrouvés 
                et des liens tissés au sein de notre communauté.
            </p>
            <div style="height: 3px; width: 60px; background: linear-gradient(90deg, var(--primary-color), var(--secondary-color)); 
                        margin: 0 auto; border-radius: 2px;"></div>
        </div>
    </div>
</section>

<!-- Call to action -->
<section class="section">
    <div class="container">
        <div style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); 
                    color: white; padding: 3rem; border-radius: var(--radius-xl); text-align: center;">
            <h2 style="font-size: 2rem; margin-bottom: 1rem; color: white;">Envie de faire partie de ces chiffres ?</h2>
            <p style="font-size: 1.125rem; margin-bottom: 2rem; opacity: 0.95;">
                Rejoignez-nous et contribuez à faire grandir notre impact positif
            </p>
            <a href="nous-rejoindre.php" class="btn btn-outline" style="font-size: 1.125rem;">
                Devenir bénévole
            </a>
        </div>
    </div>
</section>

<style>
@media (max-width: 768px) {
    section div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
