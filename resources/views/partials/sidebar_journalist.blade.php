<nav class="pc-sidebar">

  <div class="navbar-wrapper">

    <div class="m-header">
      <h4 style="color:white; text-align:center;">📝 JOURNALISTE</h4>
    </div>

    <div class="navbar-content">
      <ul class="pc-navbar">

        <!-- DASHBOARD -->
        <li class="pc-item">
          <a href="{{ route('journalist.dashboard') }}" class="pc-link">
            📊 Dashboard
          </a>
        </li>

        {{-- ================= DOCUMENTS ================= --}}
        @can('publish documents')
        <li class="pc-item">
          <a href="#" class="pc-link">
            ➕ Publier document
          </a>
        </li>
        @endcan

        @can('edit own documents')
        <li class="pc-item">
          <a href="#" class="pc-link">
            📄 Mes documents
          </a>
        </li>
        @endcan

        @can('delete own documents')
        <li class="pc-item">
          <a href="#" class="pc-link">
            🗑️ Corbeille
          </a>
        </li>
        @endcan

        {{-- ================= ARTICLES ================= --}}
        @can('publish articles')
        <li class="pc-item">
          <a href="#" class="pc-link">
            📰 Publier article
          </a>
        </li>
        @endcan

        @can('edit own articles')
        <li class="pc-item">
          <a href="#" class="pc-link">
            ✏️ Mes articles
          </a>
        </li>
        @endcan

        {{-- ================= ACCESS SETTINGS ================= --}}
        @can('set document access')
        <li class="pc-item">
          <a href="#" class="pc-link">
            
          
          
          Gestion accès documents
          </a>
        </li>
        @endcan

        {{-- ================= STATS ================= --}}
        @can('view reports')
        <li class="pc-item">
          <a href="#" class="pc-link">
            📈 Statistiques
          </a>
        </li>
        @endcan

        {{-- ================= PROFILE ================= --}}
        <li class="pc-item">
          <a href="#" class="pc-link">
            👤 Profil
          </a>
        </li>

        {{-- LOGOUT --}}
        <li class="pc-item">
          <a href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
             class="pc-link text-danger">
            🚪 Déconnexion
          </a>
        </li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>

      </ul>
    </div>

  </div>

</nav>