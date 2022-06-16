<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-text mx-3">PT Madu Baru</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        SPK APP
    </div>

    <!-- Nav Item -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('job-type.index') }}">
            <i class="fas fa-code-branch"></i>
            <span>Tipe Karyawan</span></a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('employee.index') }}">
            <i class="fas fa-people-carry"></i>
            <span>Data Karyawan</span></a>
    </li>
    <!-- Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCriteria" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span href="{{ route('criteria.index') }}">Manajemen Kriteria</span>
        </a>
        <div id="collapseCriteria" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item font-weight-bold" href="{{ route('criteria.index') }}">Data Kriteria</a>
                @php
                    $jobs = \App\Helpers\Helper::getJobType();
                @endphp
                @foreach ($jobs as $job)
                <a class="collapse-item" href="{{ route('criteria-comparison.show', $job->id) }}">Kriteria {{ $job->job_name }}</a>
                @endforeach
            </div>
        </div>
    </li>
    </li>

    <!-- Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmployee" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-folder-open"></i>
            <span>Olah Data Karyawan</span>
        </a>
        <div id="collapseEmployee" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @foreach ($jobs as $job)
                <a class="collapse-item" href="{{ route('data-process.show', $job->id) }}">Olah Data {{ $job->job_name }}</a>
                @endforeach
            </div>
        </div>
    </li>

    <!-- Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-folder-open"></i>
            <span>Penilaian Karyawan</span>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('contract-option.index') }}">Opsi Kontrak Karyawan</a>
                <a class="collapse-item" href="{{ route('ranking.index')}}">Penilaian Karyawan</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
