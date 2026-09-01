<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plugin;
use App\Support\Programs;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class PluginController extends Controller
{
    public function index()
    {
        $plugins = Plugin::orderByDesc('created_at')->get();
        return view('admin.plugins.index', ['title' => 'Pluginlərin idarəsi', 'plugins' => $plugins]);
    }

    public function create()
    {
        return view('admin.plugins.form', ['title' => 'Yeni Plugin', 'plugin' => null, 'programs' => Programs::plugins()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'plugin_file' => ['required', 'file'],
        ]);

        $pluginFile = $request->file('plugin_file');
        $storedPluginPath = $this->storeUpload($pluginFile);

        Plugin::create([
            'name' => $data['name'],
            'description' => $request->input('description', ''),
            'compatible_program' => $request->input('compatible_program', ''),
            'version' => $request->input('version', '1.0'),
            'icon' => $this->storeUpload($request->file('icon_file')) ?? '/icons/plugin-default.png',
            'preview_video' => $this->storeUpload($request->file('preview_video_file')),
            'file_path' => $storedPluginPath,
            'file_original_name' => $pluginFile->getClientOriginalName(),
            'file_size' => $pluginFile->getSize(),
            'uploaded_by' => Auth::id(),
        ]);

        return redirect('/admin/plugins')->with('success', "\"{$data['name']}\" plugini əlavə edildi.");
    }

    public function edit(Plugin $plugin)
    {
        return view('admin.plugins.form', ['title' => 'Plugini redaktə et', 'plugin' => $plugin, 'programs' => Programs::plugins()]);
    }

    public function update(Request $request, Plugin $plugin)
    {
        $data = $request->validate(['name' => ['required', 'string']]);

        $filePath = $plugin->file_path;
        $fileOriginalName = $plugin->file_original_name;
        $fileSize = $plugin->file_size;
        if ($request->hasFile('plugin_file')) {
            $pluginFile = $request->file('plugin_file');
            $filePath = $this->storeUpload($pluginFile);
            $fileOriginalName = $pluginFile->getClientOriginalName();
            $fileSize = $pluginFile->getSize();
        }

        $plugin->update([
            'name' => $data['name'],
            'description' => $request->input('description', ''),
            'compatible_program' => $request->input('compatible_program', ''),
            'version' => $request->input('version', '1.0'),
            'icon' => $this->storeUpload($request->file('icon_file')) ?? $plugin->icon,
            'preview_video' => $this->storeUpload($request->file('preview_video_file')) ?? $plugin->preview_video,
            'file_path' => $filePath,
            'file_original_name' => $fileOriginalName,
            'file_size' => $fileSize,
        ]);

        return redirect('/admin/plugins')->with('success', "\"{$data['name']}\" plugini yeniləndi.");
    }

    public function destroy(Plugin $plugin)
    {
        $plugin->delete();
        return redirect('/admin/plugins')->with('success', "\"{$plugin->name}\" plugini silindi.");
    }

    private function storeUpload(?UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }
        $safe = preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $filename = time() . '-' . $safe;
        $file->move(public_path('uploads/plugins'), $filename);
        return '/uploads/plugins/' . $filename;
    }
}
