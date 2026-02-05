# Proposal: Optimize QR Code Generation

This proposal aims to optimize the generation of thousands of QR codes for empty devices by switching to SVG format, reducing database overhead, and optimizing disk I/O.

## Problem
The current QR code generation process has several bottlenecks:
1. **Database Overhead**: For every QR code generated, a database query is performed to find the next available `RENA-` number. Generating 1,000 QR codes results in 1,000+ queries.
2. **Disk I/O and Format**: Using PNG format requires binary image processing (GD/Imagick) and results in larger file sizes compared to SVG.
3. **Execution Time**: The sequential nature of individual file writes and database checks makes it slow to generate large batches of QR codes.

## Solution
1. **Switch to SVG**: Use `milon/barcode`'s `getBarcodeSVG()` method to generate vector-based QR codes. SVG is faster to generate, smaller in size, and more suitable for high-quality printing.
2. **In-Memory Sequence Management**: Fetch the current maximum `device_number` once at the beginning of the job and increment it in memory. This eliminates per-record database lookups.
3. **Bulk Database Insertion**: Collect all generated device data into an array and perform a single `DB::table('devices')->insert()` call at the end of the process.
4. **Optimized File Storage**: Ensure file paths use the `.svg` extension and are stored efficiently.

## Scope
- `app/Jobs/GenerateMultipleQRCodesJob.php`: Main optimization of the generation logic.
- `app/Services/QRCodeService.php`: Update service methods to support SVG and optimized bulk generation.
- `app/Filament/Dashboard/Resources/Devices/Pages/ListDevices.php`: Potential adjustments to batch limits if needed.
