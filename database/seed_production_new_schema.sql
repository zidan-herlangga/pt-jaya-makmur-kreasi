-- Production data adapted for new schema (area, token)
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- advertising_points (with area replacing location_name & city)
CREATE TABLE IF NOT EXISTS dvertising_points (
  id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  category_id bigint(20) UNSIGNED NOT NULL,
  	itle varchar(200) NOT NULL,
  slug varchar(220) NOT NULL,
  rea varchar(50) DEFAULT NULL,
  lat decimal(10,8) DEFAULT NULL,
  long decimal(11,8) DEFAULT NULL,
  orientation varchar(20) DEFAULT NULL,
  size_dimension varchar(50) DEFAULT NULL,
  light_type varchar(30) DEFAULT NULL,
  price decimal(15,2) DEFAULT NULL,
  status enum('available','booked','maintenance') NOT NULL DEFAULT 'available',
  	humbnail varchar(255) DEFAULT NULL,
  gallery longtext DEFAULT NULL,
  description text DEFAULT NULL,
  meta_title varchar(255) DEFAULT NULL,
  meta_description text DEFAULT NULL,
  meta_keywords text DEFAULT NULL,
  og_image varchar(255) DEFAULT NULL,
  json_ld_schema longtext DEFAULT NULL,
  iew_count int(10) UNSIGNED NOT NULL DEFAULT 0,
  published_at timestamp NULL DEFAULT NULL,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  deleted_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY slug_unique (slug),
  KEY slug_index (slug),
  KEY status_index (status),
  KEY rea_index (rea),
  KEY category_id_index (category_id),
  KEY status_area_index (status,rea),
  KEY status_category_id_index (status,category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO dvertising_points (id, category_id, 	itle, slug, rea, lat, long, orientation, size_dimension, light_type, price, status, 	humbnail, gallery, description, meta_title, meta_description, meta_keywords, og_image, iew_count, published_at, created_at, updated_at, deleted_at) VALUES
(13, 1, 'Billboard', 'billboard', 'jabodetabek', NULL, NULL, 'horizontal', 'Custom', 'LED', NULL, 'available', 'advertising-points/billboard.webp', '[]', 'Sewa Billboard premium strategis di area utama Jabodetabek.', 'Sewa Billboard LED Horizontal Jabodetabek', 'Cari papan iklan luar ruang strategis?', 'sewa billboard jabodetabek', 'advertising-points/og/billboard-og_og.webp', 47, '2026-05-13 16:35:00', '2026-05-13 16:36:21', '2026-05-28 05:03:04', NULL),
(14, 3, 'Videotron', 'videotron', 'jabodetabek', NULL, NULL, NULL, 'Custom', 'LED', NULL, 'available', 'advertising-points/videotron.webp', '[]', 'Jasa sewa Videotron custom dari PT. Jaya Makmur Kreasi.', 'Sewa Videotron Jabodetabek - LED Digital Ads', 'Sewa Videotron LED Digital di Jabodetabek.', 'sewa videotron jakarta', 'advertising-points/og/videotron-og_og.webp', 20, '2026-05-16 18:59:00', '2026-05-13 19:00:01', '2026-05-29 19:35:08', NULL),
(15, 2, 'Neonbox', 'neonbox', 'jabodetabek', NULL, NULL, NULL, 'Custom', 'None', NULL, 'available', 'advertising-points/neonbox.webp', '[]', 'Jadikan identitas bisnis Anda tetap bersinar terang 24 jam.', 'Jasa Pembuatan Neonbox Custom LED Jabodetabek', 'Buat brand Anda terlihat profesional siang dan malam.', 'neon box murah', 'advertising-points/og/neonbox-og_og.webp', 20, '2026-05-14 01:46:00', '2026-05-14 01:46:45', '2026-05-27 18:16:54', NULL),
(16, 7, 'Wallsign', 'wallsign', 'jabodetabek', NULL, NULL, NULL, 'Custom', 'Backlit', NULL, 'available', 'advertising-points/wallsign.webp', '[]', 'Ubah dinding kosong menjadi aset promosi yang berharga.', 'Jasa Pasang Wallsign Iklan Strategis Jabodetabek', 'Optimalkan dinding bangunan Anda untuk promosi brand.', 'wallsign advertising', 'advertising-points/og/wallsign-og_og.webp', 17, '2026-05-16 01:47:00', '2026-05-14 01:48:20', '2026-05-29 18:43:49', NULL),
(17, 5, 'T Banner', 't-banner', 'jabodetabek', NULL, NULL, NULL, 'Custom', 'None', NULL, 'available', 'advertising-points/t-banner.webp', '[]', 'Solusi media promosi portabel yang praktis dan efektif.', 'Sewa T-Banner & X-Banner Promosi Jabodetabek', 'Tingkatkan kunjungan toko dengan X-Banner & T-Banner custom.', 'sewa x banner', 'advertising-points/og/t-banner-og_og.webp', 15, '2026-05-14 01:49:00', '2026-05-14 01:49:52', '2026-05-29 19:37:03', NULL),
(18, 5, 'X Banner', 'x-banner', 'jabodetabek', NULL, NULL, NULL, 'Custom', 'None', NULL, 'available', 'advertising-points/x-banner.webp', '[]', 'Sewa X-Banner berkualitas premium.', 'X Banner - PT. Jaya Makmur Kreasi', 'Sewa X Banner Custom di Jabodetabek.', 'sewa x banner', 'advertising-points/og/x-banner-og_og.webp', 23, '2026-05-14 01:50:00', '2026-05-14 01:50:51', '2026-05-29 19:36:51', NULL);

-- newsletter_subscribers (with token & unsubscribed_at)
CREATE TABLE IF NOT EXISTS 
ewsletter_subscribers (
  id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  email varchar(255) NOT NULL,
  	oken varchar(64) DEFAULT NULL,
  subscribed_at timestamp NULL DEFAULT NULL,
  unsubscribed_at timestamp NULL DEFAULT NULL,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY email_unique (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- migrations (added new migration entries 18 & 19)
CREATE TABLE IF NOT EXISTS migrations (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  migration varchar(255) NOT NULL,
  atch int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO migrations (id, migration, atch) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_11_063847_create_permission_tables', 1),
(5, '2026_05_11_063900_create_categories_table', 1),
(6, '2026_05_11_063910_create_advertising_points_table', 1),
(7, '2026_05_11_063920_create_posts_table', 1),
(8, '2026_05_11_063930_create_inquiries_table', 1),
(9, '2026_05_11_063940_add_role_fields_to_users', 1),
(10, '2026_05_11_064000_create_portfolios_table', 1),
(11, '2026_05_12_000001_create_settings_table', 1),
(12, '2026_05_13_000001_add_banner_settings', 1),
(13, '2026_05_13_000002_create_newsletter_subscribers_table', 1),
(14, '2026_05_14_000001_add_seo_settings', 2),
(15, '2026_05_14_000002_add_last_login_ip_to_users', 3),
(16, '2026_05_14_000003_create_activity_logs_table', 3),
(17, '2026_05_17_000001_create_ai_models_table', 4),
(18, '2026_05_30_000001_replace_city_with_area_in_advertising_points', 5),
(19, '2026_05_30_000002_add_token_and_unsubscribed_at_to_newsletter_subscribers', 5);

COMMIT;
