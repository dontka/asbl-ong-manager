-- ============================================================
-- Données de test pour les modules avancés ASBL-ONG Manager
-- ============================================================
-- Date: 2026-02-05
-- Version: 1.0

USE asbl_ong_manager;

-- ============================================================
-- 1. USERS (Authentification - Test accounts)
-- ============================================================
-- Note: Les utilisateurs admin et test sont déjà créés par install.php
-- Ici on ajoute des utilisateurs supplémentaires pour test

INSERT INTO users (username, password, email, role) VALUES
('hr_manager', '$2y$10$..', 'hr@asbl-ong.org', 'hr_manager'),
('accountant', '$2y$10$..', 'accountant@asbl-ong.org', 'accountant'),
('project_manager', '$2y$10$..', 'pm@asbl-ong.org', 'project_manager'),
('crm_officer', '$2y$10$..', 'crm@asbl-ong.org', 'crm_officer'),
('member1', '$2y$10$..', 'member1@asbl-ong.org', 'member'),
('volunteer1', '$2y$10$..', 'volunteer1@asbl-ong.org', 'volunteer');

-- ============================================================
-- 2. EMPLOYEES (Gestion RH - Employés)
-- ============================================================
INSERT INTO employees (user_id, first_name, last_name, email, phone, birth_date, gender, nationality, 
    address, city, postal_code, country, position, department, hire_date, employment_status, 
    employment_type, salary_gross, currency) VALUES
-- Directeur
(NULL, 'Jean', 'Dupont', 'jean.dupont@asbl-ong.org', '+32 111 222 333', '1980-05-15', 'M', 'Belge',
    'Rue du Travail 1', 'Bruxelles', '1000', 'Belgique', 'Directeur Général', 'Direction', '2020-01-15', 'active', 'CDI', 4500.00, 'EUR'),

-- RH
(NULL, 'Alice', 'Johnson', 'alice.johnson@asbl-ong.org', '+32 111 222 444', '1985-08-20', 'F', 'Britannique',
    'Rue de la Paix 2', 'Bruxelles', '1000', 'Belgique', 'Responsable RH', 'Ressources Humaines', '2021-03-15', 'active', 'CDI', 3200.00, 'EUR'),

-- Comptable
(NULL, 'Bob', 'Smith', 'bob.smith@asbl-ong.org', '+32 222 333 444', '1982-11-10', 'M', 'Français',
    'Avenue des Employés 2', 'Bruxelles', '1000', 'Belgique', 'Comptable', 'Finances', '2021-06-01', 'active', 'CDI', 2800.00, 'EUR'),

-- Chef de projet
(NULL, 'Claire', 'Davis', 'claire.davis@asbl-ong.org', '+32 333 444 555', '1988-02-28', 'F', 'Allemande',
    'Place du Bureau 3', 'Bruxelles', '1000', 'Belgique', 'Chef de Projet', 'Projets', '2021-09-20', 'active', 'CDI', 3000.00, 'EUR'),

-- Chargé CRM
(NULL, 'Marie', 'Martin', 'marie.martin@asbl-ong.org', '+32 444 555 666', '1990-07-12', 'F', 'Belge',
    'Rue de la Relation 4', 'Bruxelles', '1000', 'Belgique', 'Chargée CRM', 'Relations', '2022-01-10', 'active', 'CDD', 2500.00, 'EUR'),

-- Stagiaire
(NULL, 'Thomas', 'Lefevre', 'thomas.lefevre@asbl-ong.org', '+32 555 666 777', '1998-12-05', 'M', 'Belge',
    'Rue de l''Apprentissage 5', 'Bruxelles', '1000', 'Belgique', 'Stagiaire Marketing', 'Communications', '2023-09-01', 'active', 'Stage', 800.00, 'EUR');

-- ============================================================
-- 3. CONTRACTS (Gestion RH - Contrats)
-- ============================================================
INSERT INTO contracts (employee_id, contract_type, contract_number, start_date, end_date, status, 
    position_title, salary, working_hours) VALUES
(1, 'CDI', 'CONT-001-2020', '2020-01-15', NULL, 'active', 'Directeur Général', 4500.00, 35),
(2, 'CDI', 'CONT-002-2021', '2021-03-15', NULL, 'active', 'Responsable RH', 3200.00, 35),
(3, 'CDI', 'CONT-003-2021', '2021-06-01', NULL, 'active', 'Comptable', 2800.00, 35),
(4, 'CDI', 'CONT-004-2021', '2021-09-20', NULL, 'active', 'Chef de Projet', 3000.00, 35),
(5, 'CDD', 'CONT-005-2022', '2022-01-10', '2023-12-31', 'active', 'Chargée CRM', 2500.00, 35),
(6, 'Stage', 'CONT-006-2023', '2023-09-01', '2024-02-29', 'active', 'Stagiaire Marketing', 800.00, 20);

-- ============================================================
-- 4. ABSENCES (Gestion RH - Absences et Congés)
-- ============================================================
INSERT INTO absences (employee_id, type, start_date, end_date, status) VALUES
(2, 'conge', '2023-12-20', '2023-12-25', 'valide'),
(3, 'maladie', '2023-11-15', '2023-11-17', 'valide'),
(4, 'conge', '2023-08-01', '2023-08-14', 'valide'),
(5, 'conge', '2024-01-05', '2024-01-12', 'demande'),
(6, 'autre', '2023-10-20', '2023-10-20', 'valide');

-- ============================================================
-- 5. PAYROLL (Gestion RH - Paie)
-- ============================================================
INSERT INTO payroll (employee_id, payroll_month, payroll_year, salary_gross, salary_net, taxes, social_contributions, 
    status, payment_date) VALUES
(1, 12, 2023, 4500.00, 3150.00, 945.00, 405.00, 'paid', '2023-12-28'),
(2, 12, 2023, 3200.00, 2240.00, 672.00, 288.00, 'paid', '2023-12-28'),
(3, 12, 2023, 2800.00, 1960.00, 588.00, 252.00, 'paid', '2023-12-28'),
(4, 12, 2023, 3000.00, 2100.00, 630.00, 270.00, 'paid', '2023-12-28'),
(5, 12, 2023, 2500.00, 1750.00, 525.00, 225.00, 'paid', '2023-12-28'),
(6, 12, 2023, 800.00, 640.00, 128.00, 32.00, 'paid', '2023-12-28');

-- ============================================================
-- 6. POINTAGES (Gestion RH - Pointages)
-- ============================================================
INSERT INTO pointages (employee_id, date, heures, type) VALUES
(1, '2023-12-01', 8.0, 'travail'),
(1, '2023-12-02', 8.0, 'travail'),
(2, '2023-12-01', 8.0, 'travail'),
(2, '2023-12-02', 8.0, 'travail'),
(3, '2023-12-01', 7.5, 'travail'),
(3, '2023-12-02', 8.0, 'travail'),
(4, '2023-12-01', 8.0, 'travail'),
(5, '2023-12-01', 8.0, 'travail'),
(6, '2023-12-01', 4.0, 'travail');

-- ============================================================
-- 7. FACTURES (Gestion Financière - Factures)
-- ============================================================
INSERT INTO factures (numero, date, client, montant, statut) VALUES
('F2023-001', '2023-10-01', 'Fournisseur A - Fournitures', 1200.00, 'payee'),
('F2023-002', '2023-10-15', 'Fournisseur B - Services', 800.00, 'envoyee'),
('F2023-003', '2023-11-01', 'Fournisseur C - Équipement', 1500.00, 'brouillon'),
('F2023-004', '2023-11-20', 'Fournisseur D - Transport', 650.00, 'payee');

-- ============================================================
-- 8. RELEVES BANCAIRES (Gestion Financière - Trésorerie)
-- ============================================================
INSERT INTO releves_bancaires (date, solde, fichier) VALUES
('2023-12-01', 25000.00, 'releve_dec_2023.pdf'),
('2023-11-01', 22000.00, 'releve_nov_2023.pdf'),
('2023-10-01', 19500.00, 'releve_oct_2023.pdf');

-- ============================================================
-- 9. PROJECTS (Gestion des Projets)
-- ============================================================
INSERT INTO projects (name, description, start_date, end_date, budget, status, manager_id) VALUES
('Environnement - Campagne Sensibilisation', 
    'Campagne de sensibilisation à l''environnement et développement durable', 
    '2023-01-15', '2023-12-31', 5000.00, 'completed', 4),
    
('Aide Alimentaire - Distribution 2023', 
    'Distribution alimentaire aux populations en détresse', 
    '2023-06-01', '2024-03-31', 10000.00, 'active', 4),
    
('Éducation - Alphabétisation', 
    'Programme d''alphabétisation pour adultes', 
    '2023-09-01', '2024-06-30', 7500.00, 'active', 4),
    
('Santé Communautaire - Clinique Mobile', 
    'Service de santé mobile dans les quartiers périphériques', 
    '2024-01-01', '2024-12-31', 12000.00, 'planning', 4);

-- ============================================================
-- 10. BUDGETS (Gestion Financière - Budgets)
-- ============================================================
INSERT INTO budgets (project_id, name, amount, currency, period) VALUES
(1, 'Budget Environnement 2023', 5000.00, 'EUR', '2023'),
(2, 'Budget Aide Alimentaire 2023', 10000.00, 'EUR', '2023'),
(3, 'Budget Éducation 2023', 7500.00, 'EUR', '2023');

-- ============================================================
-- 11. ÉCRITURES COMPTABLES (Gestion Financière - Comptabilité)
-- ============================================================
INSERT INTO ecritures (date, description, debit, credit, project_id) VALUES
('2023-12-01', 'Facture fournisseur A', 1200.00, 0.00, 1),
('2023-12-02', 'Paiement fournitures', 0.00, 1200.00, 1),
('2023-12-03', 'Service de nettoyage', 500.00, 0.00, 2),
('2023-12-05', 'Donation reçue', 0.00, 1000.00, 1);

-- ============================================================
-- 12. DONATIONS (Gestion des Dons)
-- ============================================================
INSERT INTO donations (donor_name, donor_email, amount, donation_date, project_id, payment_method) VALUES
('Jean Dupont', 'jean@email.com', 250.00, '2023-12-01', 1, 'bank_transfer'),
('Marie Curie', 'marie@email.com', 500.00, '2023-12-05', 2, 'online'),
('Pierre David', 'pierre@email.com', 100.00, '2023-12-10', 1, 'cash'),
('Foundation XYZ', 'contact@foundation.org', 5000.00, '2023-11-15', 2, 'bank_transfer'),
('Société ABC', 'rh@societe.com', 2000.00, '2023-10-20', 3, 'bank_transfer'),
('Anonyme', NULL, 50.00, '2023-12-08', 1, 'cash');

-- ============================================================
-- 13. TACHES (Gestion des Projets - Tâches)
-- ============================================================
INSERT INTO taches (project_id, titre, description, responsable_id, statut, echeance) VALUES
(1, 'Campagne de sensibilisation', 'Créer les supports de communication (affiches, vidéos, dépliants)', 4, 'terminee', '2023-12-15'),
(1, 'Partenariats écoles', 'Contacter 15 écoles locales pour partenariats', 4, 'terminee', '2023-12-20'),
(2, 'Distribution alimentaire', 'Organiser la logistique et les points de distribution', 4, 'en_cours', '2024-01-10'),
(2, 'Formation bénévoles', 'Former les bénévoles aux droits des bénéficiaires', 1, 'en_cours', '2024-02-15'),
(3, 'Sessions alphabétisation', 'Préparer le programme et les supports pédagogiques', 4, 'en_cours', '2024-03-31'),
(3, 'Recrutement formateurs', 'Recruter 5 formateurs qualifiés', 2, 'en_cours', '2024-01-31'),
(4, 'Acquisition véhicule médical', 'Acheter et équiper le véhicule clinique mobile', 4, 'a_faire', '2024-03-15');

-- ============================================================
-- 14. JALONS (Gestion des Projets - Jalons/Milestones)
-- ============================================================
INSERT INTO jalons (project_id, nom, description, date) VALUES
(1, 'Lancement campagne', 'Lancement officiel de la campagne de sensibilisation', '2023-02-01'),
(1, 'Partenariats signés', '15 écoles partenaires engagées', '2023-12-31'),
(2, 'Premier site de distribution', 'Ouverture du premier point de distribution', '2023-07-01'),
(2, 'Extension à 5 sites', 'Expansion à 5 sites de distribution', '2024-01-31'),
(3, 'Recrutement complet', 'Ensemble de l''équipe de formateurs recruté', '2024-01-31');

-- ============================================================
-- 15. RISQUES (Gestion des Projets - Risques)
-- ============================================================
INSERT INTO risques (project_id, description, niveau, plan_action) VALUES
(1, 'Manque de participants aux formations', 'moyen', 'Campagne marketing supplémentaire via réseaux sociaux'),
(2, 'Retard livraison nourriture fournisseur', 'eleve', 'Diversifier les fournisseurs et constitueur stock tampon'),
(3, 'Manque d''engagement des participants', 'moyen', 'Mise en place d''incitations (certificats, repas)'),
(4, 'Difficultés d''accès aux zones reculées', 'eleve', 'Partenautés avec structures locales, routes alternatives');

-- ============================================================
-- 16. SKILLS (Gestion RH - Compétences)
-- ============================================================
INSERT INTO skills (name, category, description) VALUES
('Communication', 'Soft Skills', 'Capacité à communiquer efficacement en interne et externe'),
('Gestion de Projet', 'Management', 'Piloter des projets complexes de bout en bout'),
('Comptabilité', 'Finance', 'Tenue de la comptabilité et des finances'),
('Formatrut', 'Pédagogie', 'Capacité à former et animer des groupes'),
('Français', 'Langues', 'Maîtrise du français oral et écrit'),
('Anglais', 'Langues', 'Maîtrise de l''anglais conversationnel'),
('Base de données', 'IT', 'Maîtrise des bases de données SQL');

-- ============================================================
-- 17. EMPLOYEE SKILLS (Gestion RH - Compétences employés)
-- ============================================================
INSERT INTO employee_skills (employee_id, skill_id, proficiency_level, acquired_date) VALUES
(1, 1, 'Expert', '2015-06-01'),
(1, 2, 'Expert', '2018-01-15'),
(2, 1, 'Expert', '2018-03-20'),
(3, 3, 'Expert', '2015-09-10'),
(4, 2, 'Expert', '2019-01-05'),
(4, 1, 'Master', '2020-01-01'),
(5, 1, 'Master', '2021-01-01'),
(6, 4, 'Novice', '2023-09-01');

-- ============================================================
-- 18. TRAININGS (Gestion RH - Formations)
-- ============================================================
INSERT INTO trainings (name, provider, description, training_type, start_date, end_date, 
    duration_hours, location, cost, status) VALUES
('Gestion de projet Agile', 'Institut XYZ', 'Formation Scrum et Kanban', 'Externe', 
    '2024-02-12', '2024-02-16', 30, 'Bruxelles', 800.00, 'planned'),
    
('Leadership pour managers', 'Consultant ABC', 'Développement du leadership et gestion d''équipe', 'Externe',
    '2024-03-15', '2024-03-17', 20, 'Bruxelles', 1200.00, 'planned'),
    
('Conformité RGPD', 'Avocat Société', 'Obligations légales RGPD et sécurité données', 'Interne',
    '2024-01-25', '2024-01-25', 4, 'Siège social', 0.00, 'ongoing'),
    
('Alphabétisation pour adultes', 'Université Libre', 'Pédagogie de l''alphabétisation avancée', 'Externe',
    '2024-01-20', '2024-02-20', 40, 'Bruxelles', 600.00, 'ongoing');

-- ============================================================
-- 19. EMPLOYEE TRAININGS (Gestion RH - Participations)
-- ============================================================
INSERT INTO employee_trainings (employee_id, training_id, status, certification_obtained) VALUES
(1, 3, 'attended', 1),
(2, 3, 'attended', 1),
(3, 3, 'attended', 1),
(4, 1, 'registered', 0),
(4, 2, 'registered', 0),
(5, 4, 'registered', 0),
(6, 4, 'registered', 0);

-- ============================================================
-- 20. EVALUATIONS (Gestion RH - Évaluations)
-- ============================================================
INSERT INTO evaluations (employee_id, evaluator_id, evaluation_year, evaluation_date, 
    job_knowledge, performance, teamwork, communication, initiative, overall_score, status) VALUES
(1, 1, 2023, '2023-11-15', 5, 5, 5, 5, 5, 25, 'finalized'),
(2, 1, 2023, '2023-11-20', 4, 4, 5, 4, 4, 21, 'finalized'),
(3, 1, 2023, '2023-11-25', 4, 4, 4, 4, 4, 20, 'finalized'),
(4, 1, 2023, '2023-12-01', 5, 4, 5, 5, 4, 23, 'finalized'),
(5, 2, 2023, '2023-12-05', 3, 4, 4, 4, 3, 18, 'submitted'),
(6, 2, 2023, '2023-12-10', 3, 3, 4, 3, 3, 16, 'draft');

-- ============================================================
-- 21. MEMBERS (Gestion des Membres)
-- ============================================================
INSERT INTO members (first_name, last_name, email, phone, address, join_date, status) VALUES
('Sophie', 'Legrand', 'sophie.legrand@email.com', '+32 111 555 888', 'Rue des Avilles 10', '2022-01-20', 'active'),
('Luc', 'Bernard', 'luc.bernard@email.com', '+32 222 666 999', 'Avenue Princes 20', '2022-06-15', 'active'),
('Nathalie', 'Meunier', 'nathalie.meunier@email.com', '+32 333 777 000', 'Boulevard Charlemagne 30', '2023-02-10', 'active'),
('Georges', 'Petit', 'georges.petit@email.com', '+32 444 888 111', 'Rue de la Paix 40', '2023-09-05', 'inactive');

-- ============================================================
-- 22. EVENTS (Gestion des Événements)
-- ============================================================
INSERT INTO events (title, description, event_date, location, organizer_id, max_participants, status) VALUES
('Journée d''intégration bénévoles', 'Accueil et formation des nouveaux bénévoles 2024',
    '2024-01-20 09:00:00', 'Siège social, Bruxelles', 1, 50, 'planned'),
    
('Forum des partenaires', 'Réunion annuelle des partenaires et bailleurs de fonds',
    '2024-02-15 14:00:00', 'Centre de conférences, Bruxelles', 1, 100, 'planned'),
    
('Atelier alphabétisation', 'Session d''initiation à l''alphabétisation pour adultes',
    '2024-01-28 18:00:00', 'Local communautaire, Bruxelles', 4, 20, 'planned'),
    
('Soirée de célébration', 'Célébration des réalisations 2023',
    '2023-12-22 19:00:00', 'Restaurant partenaire', 1, 80, 'completed');

-- ============================================================
-- 23. CONTACTS (CRM - Contacts)
-- ============================================================
INSERT INTO contacts (type, nom, email, telephone, organisation) VALUES
('donateur', 'Jean Dupont', 'jean.dupont@email.com', '+32 123 456 789', 'Particulier'),
('partenaire', 'ONG Verte', 'contact@ongverte.be', '+32 987 654 321', 'ONG Environnement'),
('beneficiaire', 'Collectif Solidarité', 'contact@collectif.be', '+32 555 123 456', 'Association locale'),
('membre', 'Pierre Dubois', 'pierre.dubois@email.com', '+32 444 789 012', 'Bénévole actif'),
('partenaire', 'Municipalité Bruxelles', 'contact@bruxelles.be', '+32 800 123 456', 'Collectivité territoriale'),
('donateur', 'Foundation XYZ', 'fundation@xyz.org', '+32 666 777 888', 'Fondation de droit privé');

-- ============================================================
-- 24. CAMPAGNES (CRM - Campagnes)
-- ============================================================
INSERT INTO campagnes (nom, type, date_lancement, statut) VALUES
('Campagne Noël 2023 - Appels aux dons', 'email', '2023-12-01', 'terminee'),
('Newsletter Janvier 2024 - Bilan annuel', 'email', '2024-01-02', 'active'),
('SMS Urgence aide alimentaire', 'sms', '2024-01-15', 'active'),
('Campagne Partenaires annuelle', 'email', '2023-11-01', 'terminee');

-- ============================================================
-- 25. INTERACTIONS (CRM - Interactions)
-- ============================================================
INSERT INTO interactions (contact_id, type, date, description, utilisateur_id) VALUES
(1, 'appel', '2023-12-01 10:30:00', 'Appel de suivi - Confirmation don Noël', 5),
(2, 'reunion', '2023-12-05 15:00:00', 'Réunion annuelle partenariat ONG verte', 5),
(3, 'email', '2024-01-02 09:00:00', 'Envoi newsletter janvier', 5),
(4, 'note', '2024-01-10 14:30:00', 'Suivi bénévole - Possible domaine formation pédagogie', 1),
(5, 'appel', '2024-01-15 11:00:00', 'Appel soutien urgence alimentaire', 5);

-- ============================================================
-- 26. ENGAGEMENTS (CRM - Engagements)
-- ============================================================
INSERT INTO engagements (contact_id, campagne_id, montant, date, statut) VALUES
(1, 1, 250.00, '2023-12-02', 'recu'),
(2, 4, 5000.00, '2023-11-15', 'recu'),
(6, 1, 500.00, '2023-12-10', 'promesse'),
(1, 2, 100.00, '2024-01-05', 'promesse');

-- ============================================================
-- 27. DOCUMENTS (Gestion Documentaire)
-- ============================================================
INSERT INTO documents (nom, chemin, type, version, statut, utilisateur_id) VALUES
('Statuts et règlements internes', '/documents/statuts_2023.pdf', 'PDF', '3.0', 'actif', 1),
('Rapport d''activité 2023', '/documents/rapport_2023.pdf', 'PDF', '1.0', 'actif', 1),
('Budget prévisionnel 2024', '/documents/budget_2024.xlsx', 'XLSX', '2.0', 'actif', 3),
('Politique RGPD', '/documents/politique_rgpd.pdf', 'PDF', '1.0', 'actif', 1),
('Organigramme actualié', '/documents/organigramme_2024.png', 'PNG', '1.0', 'actif', 2),
('Base de données membership 2024', '/documents/members_2024.csv', 'CSV', '1.0', 'actif', 1);

-- ============================================================
-- 28. AUDIT TRAIL (Conformité - Suivi d''audit)
-- ============================================================
INSERT INTO audit_trail (utilisateur_id, action, description, date) VALUES
(1, 'LOGIN', 'Connexion administrateur', '2024-01-15 09:00:00'),
(5, 'CREATE_CONTACT', 'Création nouveau contact donateur', '2024-01-15 09:30:00'),
(1, 'UPDATE_BUDGET', 'Modification budget projet éducation', '2024-01-15 10:00:00'),
(3, 'CREATE_FACTURE', 'Création facture fournisseur', '2024-01-15 10:45:00'),
(1, 'EXPORT_MEMBERS', 'Export list membres pour envoi mail', '2024-01-15 11:15:00'),
(4, 'CREATE_PROJECT_TASK', 'Ajout tâche ''Recrutement formateurs''', '2024-01-15 14:30:00'),
(1, 'ARCHIVE_DOCUMENT', 'Archivage rapport 2022', '2024-01-16 09:00:00');

-- ============================================================
-- FIN DES DONNÉES DE TEST
-- ============================================================