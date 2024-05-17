<?php

namespace Deployer;

use RuntimeException;
use Symfony\Component\Process\Exception\ProcessFailedException;

class FileHelper
{
    public static function copyFile($src, $dst): bool
    {
        $dstDir = dirname($dst);
        $result = false;
        if (!self::fileExists($dst)) {
            if (!self::dirExists($dstDir)) {
                run("mkdir -p \"$dstDir\"");
            }
            run("cp \"$src\" \"$dst\"");
            $result = true;
        }

        return $result;
    }

    public static function generateFile(
        string $srcFilename,
        string $dstFilename,
        string $mode = null,
        array $copyOnce = []
    ): string {
        $mode = !is_null($mode) ? $mode : null;
        $copyOnce = array_map(
            static function ($value) {
                return parse($value);
            },
            $copyOnce
        );
        if (in_array($srcFilename, $copyOnce, true) && self::fileExists($dstFilename)) {
            !isDebug() ?: writeln(sprintf('File "%s" skipped, because is in copyOnce list', $srcFilename));
            return '';
        }
        $dstDir = dirname($dstFilename);
        if (!self::fileExists($srcFilename)) {
            throw new RuntimeException(
                parse('Src file "' . $srcFilename . '" does not exists')
            );
        }
        $command = sprintf('if [ -d "%s" ]; then mkdir -p "%s"; fi', $dstDir, $dstDir);
        run($command);
        $dstDir = dirname($dstFilename);
        if (!self::dirExists($dstDir)) {
            run(sprintf('mkdir -p "%s"', $dstDir));
        }
        $content = run(sprintf('cat "%s"', $srcFilename));
        $content = parse($content);
        $command = sprintf("echo '%s' > %s", $content, $dstFilename);
        run($command);
        if (is_null($mode)) {
            try {
                $command = sprintf('stat -c "%%a" % s', $srcFilename);
                $mode = trim(run($command));
            } catch (ProcessFailedException $e) {
                $command = sprintf('stat -f "%%A" % s', $srcFilename);
                $mode = trim(run($command));
            }
        }
        $command = sprintf('chmod %s "%s"', $mode, $dstFilename);
        run($command);

        return $dstFilename;
    }

    public static function generateFiles(
        string $srcDir,
        string $dstDir,
        array $copyOnce = []
    ): array {
        $characters = ' / ';
        $srcDir = rtrim($srcDir, $characters);
        $dstDir = rtrim($dstDir, $characters);
        $command = sprintf('find "%s" -type f', $srcDir);
        $templateFiles = explode("\n", run($command));
        $result = [];
        foreach ($templateFiles as $src) {
            $name = str_replace($srcDir, '', $src);
            $dst = sprintf('%s%s', $dstDir, $name);
            $res = self::generateFile($src, $dst, null, $copyOnce);
            if ($res) {
                $result[] = $dst;
            }
        }

        return $result;
    }

    public static function dirExists(string $dir, string $workingPath = null): bool
    {
        return (bool)self::runWithin("if [ -d \"$dir\" ]; then echo 1; fi", $workingPath);
    }

    public static function fileExists(string $filename, string $workingPath = null): bool
    {
        return (bool)self::runWithin("if [ -f \"$filename\" ]; then echo 1; fi", $workingPath);
    }

    public static function isWritable(string $filename, string $workingPath = null): bool
    {
        $cmd = sprintf('if [ -w "%s" ]; then echo true; fi', $filename);
        return (bool)self::runWithin($cmd, $workingPath);
    }

    public static function runWithin(string $command, string $workingPath = null): ?string
    {
        $result = null;
        if (is_null($workingPath)) {
            $result = run($command);
        } else {
            within(
                $workingPath,
                function () use ($command, &$result) {
                    $result = run($command);
                }
            );
        }

        return $result;
    }
}
