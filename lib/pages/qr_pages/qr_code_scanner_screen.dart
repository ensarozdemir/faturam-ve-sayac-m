import 'package:qr_code/imports_screens.dart';
import 'package:qr_code_scanner/qr_code_scanner.dart';
import 'qr_code_result_screen.dart'; // Import the new screen
import 'package:http/http.dart' as http;

class QRCodeScannerScreen extends StatefulWidget {
  final String result;
  final String billType;
  final String tc;

  const QRCodeScannerScreen({
    required this.result,
    required this.billType,
    required this.tc,
  });

  @override
  _QRCodeScannerScreenState createState() => _QRCodeScannerScreenState();
}

class _QRCodeScannerScreenState extends State<QRCodeScannerScreen> {
  final GlobalKey qrKey = GlobalKey(debugLabel: 'QR');
  QRViewController? controller;

  bool _isLoading = false;
  String _resultMessage = '';

  Future<void> _readBill(String billType, String tc) async {
    setState(() {
      _isLoading = true;
      _resultMessage = '';
    });

    final response = await http.post(
      Uri.parse('${AppConstant.url}read_bill.php'),
      headers: <String, String>{
        'Content-Type': 'application/json; charset=UTF-8',
      },
      body: jsonEncode(<String, String>{
        'tc': tc,
        'bill_type': billType,
      }),
    );

    if (response.statusCode == 200) {
      final Map<String, dynamic> responseData = jsonDecode(response.body);
      setState(() {
        if (responseData.containsKey('error')) {
          _resultMessage = responseData['error'];
        } else if (responseData.containsKey('message')) {
          _resultMessage = responseData['message'];
        } else if (responseData.containsKey('qr_code')) {
          // Navigate to QR code result screen with the QR code data
          // Navigator.push(
          //   context,
          //   MaterialPageRoute(
          //     builder: (context) =>
          //         QRCodeResultScreen(result: responseData['qr_code']),
          //   ),
          // );
        }
      });
    } else {
      setState(() {
        _resultMessage = 'An error occurred. Please try again.';
      });
    }

    setState(() {
      _isLoading = false;
    });
  }

  @override
  void reassemble() {
    super.reassemble();
    if (controller != null) {
      controller!.pauseCamera();
      controller!.resumeCamera();
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: true,
        backgroundColor: backgroundColor,
        foregroundColor: blackColor2,
        elevation: 0,
        centerTitle: false,
        title: const Text(
          "QR Code Scanner",
          style: TextStyle(
            fontWeight: FontWeight.w700,
          ),
        ),
      ),
      body: Column(
        children: <Widget>[
          Expanded(
            flex: 5,
            child: Image.asset(ImagesConstant.qr_code),

            // QRView(
            //   key: qrKey,
            //   onQRViewCreated: _onQRViewCreated,
            // ),
          ),
          Expanded(
            flex: 1,
            child: GestureDetector(
              onTap: () {
                // Navigate to the next screen with the QR code data
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (context) => QRCodeResultScreen(
                      result: widget.result,
                      tc: widget.tc,
                      billType: widget.billType,
                    ),
                  ),
                );
              },
              child: const Center(
                child: Text("QR'i Tarayın"),
              ),
            ),
          ),
        ],
      ),
    );
  }

  void _onQRViewCreated(QRViewController controller) {
    this.controller = controller;
    controller.scannedDataStream.listen((scanData) {
      setState(() {
        controller.pauseCamera(); // Pause the camera to prevent multiple scans
        // Navigator.push(
        //   context,
        //   MaterialPageRoute(
        //     builder: (context) => QRCodeResultScreen(result: scanData.code!),
        //   ),
        // ).then((value) {
        //   controller.resumeCamera(); // Resume the camera when returning
        // });
      });
    });
  }

  @override
  void dispose() {
    controller?.dispose();
    super.dispose();
  }
}
