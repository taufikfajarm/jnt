-- ============================================================
-- FIX: Enable Row Level Security (RLS) on all public tables
-- 
-- Context:
--   - This app uses Laravel for authentication (sessions)
--   - The frontend uses the Supabase JS client with anon key 
--     to directly read/write application data
--   - Since there's no Supabase Auth, the "anon" role is used
--     for all frontend requests
--
-- Strategy:
--   1. APPLICATION TABLES (pelanggans, pakets, kabupatens, 
--      kecamatans, desas, sales, pembayarans):
--      → Enable RLS + allow full CRUD for "anon" role
--
--   2. INTERNAL/SENSITIVE TABLES (users, sessions, cache, 
--      migrations, jobs, password_reset_tokens, etc.):
--      → Enable RLS + NO policies = blocks all API access
--      → These tables are only accessed server-side by Laravel
-- ============================================================

-- ============================================================
-- STEP 1: Enable RLS on ALL tables
-- ============================================================

ALTER TABLE public.pelanggans ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.pakets ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.kabupatens ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.kecamatans ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.desas ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.sales ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.pembayarans ENABLE ROW LEVEL SECURITY;

-- Internal Laravel tables (RLS enabled, NO policies = blocked from API)
ALTER TABLE public.users ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.sessions ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.cache ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.cache_locks ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.migrations ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.jobs ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.job_batches ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.failed_jobs ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.password_reset_tokens ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.personal_access_tokens ENABLE ROW LEVEL SECURITY;


-- ============================================================
-- STEP 2: Create RLS policies for APPLICATION tables
-- (Allow anon role full CRUD access)
-- ============================================================

-- ---- pelanggans ----
CREATE POLICY "Allow anon select on pelanggans"
  ON public.pelanggans FOR SELECT
  TO anon USING (true);

CREATE POLICY "Allow anon insert on pelanggans"
  ON public.pelanggans FOR INSERT
  TO anon WITH CHECK (true);

CREATE POLICY "Allow anon update on pelanggans"
  ON public.pelanggans FOR UPDATE
  TO anon USING (true) WITH CHECK (true);

CREATE POLICY "Allow anon delete on pelanggans"
  ON public.pelanggans FOR DELETE
  TO anon USING (true);

-- ---- pakets ----
CREATE POLICY "Allow anon select on pakets"
  ON public.pakets FOR SELECT
  TO anon USING (true);

CREATE POLICY "Allow anon insert on pakets"
  ON public.pakets FOR INSERT
  TO anon WITH CHECK (true);

CREATE POLICY "Allow anon update on pakets"
  ON public.pakets FOR UPDATE
  TO anon USING (true) WITH CHECK (true);

CREATE POLICY "Allow anon delete on pakets"
  ON public.pakets FOR DELETE
  TO anon USING (true);

-- ---- kabupatens ----
CREATE POLICY "Allow anon select on kabupatens"
  ON public.kabupatens FOR SELECT
  TO anon USING (true);

CREATE POLICY "Allow anon insert on kabupatens"
  ON public.kabupatens FOR INSERT
  TO anon WITH CHECK (true);

CREATE POLICY "Allow anon update on kabupatens"
  ON public.kabupatens FOR UPDATE
  TO anon USING (true) WITH CHECK (true);

CREATE POLICY "Allow anon delete on kabupatens"
  ON public.kabupatens FOR DELETE
  TO anon USING (true);

-- ---- kecamatans ----
CREATE POLICY "Allow anon select on kecamatans"
  ON public.kecamatans FOR SELECT
  TO anon USING (true);

CREATE POLICY "Allow anon insert on kecamatans"
  ON public.kecamatans FOR INSERT
  TO anon WITH CHECK (true);

CREATE POLICY "Allow anon update on kecamatans"
  ON public.kecamatans FOR UPDATE
  TO anon USING (true) WITH CHECK (true);

CREATE POLICY "Allow anon delete on kecamatans"
  ON public.kecamatans FOR DELETE
  TO anon USING (true);

-- ---- desas ----
CREATE POLICY "Allow anon select on desas"
  ON public.desas FOR SELECT
  TO anon USING (true);

CREATE POLICY "Allow anon insert on desas"
  ON public.desas FOR INSERT
  TO anon WITH CHECK (true);

CREATE POLICY "Allow anon update on desas"
  ON public.desas FOR UPDATE
  TO anon USING (true) WITH CHECK (true);

CREATE POLICY "Allow anon delete on desas"
  ON public.desas FOR DELETE
  TO anon USING (true);

-- ---- sales ----
CREATE POLICY "Allow anon select on sales"
  ON public.sales FOR SELECT
  TO anon USING (true);

CREATE POLICY "Allow anon insert on sales"
  ON public.sales FOR INSERT
  TO anon WITH CHECK (true);

CREATE POLICY "Allow anon update on sales"
  ON public.sales FOR UPDATE
  TO anon USING (true) WITH CHECK (true);

CREATE POLICY "Allow anon delete on sales"
  ON public.sales FOR DELETE
  TO anon USING (true);

-- ---- pembayarans ----
CREATE POLICY "Allow anon select on pembayarans"
  ON public.pembayarans FOR SELECT
  TO anon USING (true);

CREATE POLICY "Allow anon insert on pembayarans"
  ON public.pembayarans FOR INSERT
  TO anon WITH CHECK (true);

CREATE POLICY "Allow anon update on pembayarans"
  ON public.pembayarans FOR UPDATE
  TO anon USING (true) WITH CHECK (true);

CREATE POLICY "Allow anon delete on pembayarans"
  ON public.pembayarans FOR DELETE
  TO anon USING (true);


-- ============================================================
-- STEP 3: INTERNAL/SENSITIVE tables → NO policies created
-- 
-- RLS is enabled but NO policies exist, which means:
--   - anon role CANNOT read/write these tables via the API
--   - Laravel (using the postgres role directly) bypasses RLS
--   - This protects: passwords, tokens, sessions, etc.
-- ============================================================

-- Done! The following tables are now BLOCKED from Supabase API:
--   • users (contains password column)
--   • password_reset_tokens (contains token column)
--   • personal_access_tokens (contains token column)
--   • sessions
--   • cache
--   • cache_locks
--   • migrations
--   • jobs
--   • job_batches
--   • failed_jobs
