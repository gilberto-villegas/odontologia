<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\HistoriaMedicaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\RegistroController;
use App\Models\Configuracion;
use App\Models\Plan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistema de Membresía Odontológica
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. RUTAS PÚBLICAS
// ==========================================
Route::get('/', function () {
    $planes = Plan::where('activo', true)->get();
    $configuraciones = Configuracion::pluck('valor', 'clave')->toArray();
    return view('index', compact('planes', 'configuraciones'));
})->name('inicio');

// Autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registro y Afiliación
Route::get('/registro', [RegistroController::class, 'showRegistro'])->name('registro');
Route::post('/registro', [RegistroController::class, 'register'])->name('registro.post');

// Pagos Móviles
Route::get('/pago', [PagoController::class, 'showPago'])->name('pago');
Route::post('/pago', [PagoController::class, 'store'])->name('pago.store');
Route::get('/pago-exitoso', [PagoController::class, 'exitoso'])->name('pago.exitoso');

// Formulario de Contacto
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');


// ==========================================
// 2. RUTAS PROTEGIDAS: PACIENTE
// ==========================================
Route::middleware(['auth', 'rol:paciente'])->group(function () {
    Route::get('/dashboard-paciente', [PacienteController::class, 'dashboard'])->name('paciente.dashboard');
    Route::get('/agendar-cita', [CitaController::class, 'create'])->name('paciente.citas.create');
    Route::post('/agendar-cita', [CitaController::class, 'store'])->name('paciente.citas.store');
    Route::get('/historial-clinico', [PacienteController::class, 'historial'])->name('paciente.historial');
    Route::get('/mi-plan', [PacienteController::class, 'miPlan'])->name('paciente.plan');
});


// ==========================================
// 3. RUTAS PROTEGIDAS: ADMINISTRADOR
// ==========================================
Route::middleware(['auth', 'rol:administrador'])->prefix('admin')->name('admin.')->group(function () {
    // Panel de Control Principal
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Validación y Gestión de Pagos
    Route::get('/pagos', [AdminController::class, 'index'])->name('pagos.index');
    Route::post('/pagos/{id}/aprobar', [PagoController::class, 'aprobar'])->name('pagos.aprobar');
    Route::post('/pagos/{id}/rechazar', [PagoController::class, 'rechazar'])->name('pagos.rechazar');

    // Gestión de Citas
    Route::post('/citas/{cita}/estado', [CitaController::class, 'actualizarEstado'])->name('citas.estado');

    // Historias Médicas
    Route::post('/historias', [HistoriaMedicaController::class, 'store'])->name('historias.store');

    // Configuración de Landing y Planes
    Route::post('/configuracion', [ConfiguracionController::class, 'update'])->name('configuracion.update');

    // Gestión de Pacientes
    Route::post('/pacientes/{usuario}/toggle', [AdminController::class, 'togglePaciente'])->name('pacientes.toggle');
    Route::post('/pacientes/{usuario}/extension', [AdminController::class, 'extenderMembresia'])->name('pacientes.extension');
    Route::delete('/pacientes/{usuario}', [AdminController::class, 'destroyPaciente'])->name('pacientes.destroy');
});
