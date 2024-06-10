import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

import 'package:qr_code/imports_screens.dart';

class QRCodeResultScreen extends StatelessWidget {
  final String result;
  final String tc;
  final String billType;

  QRCodeResultScreen(
      {required this.result, required this.tc, required this.billType});

  Future<void> _createBill(BuildContext context) async {
    final response = await http.post(
      Uri.parse('${AppConstant.url}create_bill.php'),
      headers: <String, String>{
        'Content-Type': 'application/json; charset=UTF-8',
      },
      body: jsonEncode(<String, String>{
        'result': result,
        'tc': tc,
        'bill_type': billType,
        'status': 'nopaid',
        'date': DateTime.now().toString(),
      }),
    );

    if (response.statusCode == 200) {
      final Map<String, dynamic> responseData = jsonDecode(response.body);
      if (responseData.containsKey('success')) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Fatura başarıyla oluşturuldu')),
          //navigate to the home page                Navigator.of(context).pushReplacementNamed('/bottomnavigationscreen');
        );
        Navigator.of(context).pushReplacementNamed('/bottomnavigationscreen');
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
              content: Text('Fatura oluşturulamadı: ${responseData['error']}')),
        );
      }
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Bir hata oluştu. Lütfen tekrar deneyin.')),
      );
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
          "FATURAM",
          style: TextStyle(
            fontWeight: FontWeight.w700,
          ),
        ),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Text(
              'Toplam Borç: $result tl',
              style: TextStyle(fontSize: 24),
            ),
            const SizedBox(height: 20),
            ElevatedButton(
              onPressed: () => _createBill(context),
              child: Text('Faturayı Kes'),
            ),
          ],
        ),
      ),
    );
  }
}
