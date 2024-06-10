import '../../imports_screens.dart'; // Ensure this import is correct
import 'package:http/http.dart' as http;

class LoginPage extends StatefulWidget {
  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final _formKey = GlobalKey<FormState>();

  bool login = true;

  TextEditingController _tcController = TextEditingController();
  bool _isLoading = false;
  String _errorMessage = '';

  Future<void> _checkUser() async {
    setState(() {
      _isLoading = true;
      _errorMessage = '';
    });

    final response = await http.post(
      Uri.parse('${AppConstant.url}login.php'),
      headers: <String, String>{
        'Content-Type': 'application/json; charset=UTF-8',
      },
      body: jsonEncode(<String, String>{
        'tc': _tcController.text,
      }),
    );

    if (response.statusCode == 200) {
      final Map<String, dynamic> responseData = jsonDecode(response.body);
      if (responseData.containsKey('error')) {
        setState(() {
          _errorMessage = responseData['error'];
        });
      } else {
        // Navigate to the next screen with user data
        await SharedPreferencesService.saveUserTc(_tcController.text);
        await SharedPreferencesService.saveUserLogin(true);
        Navigator.of(context).pushReplacementNamed('/bottomnavigationscreen',
            arguments: responseData['user']);
      }
    } else {
      setState(() {
        _errorMessage = 'An error occurred. Please try again.';
      });
    }

    setState(() {
      _isLoading = false;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: backgroundColor,
      appBar: AppBar(
        automaticallyImplyLeading: false,
        backgroundColor: backgroundColor,
        foregroundColor: blackColor2,
        elevation: 0,
        centerTitle: false,
        title: const Text(
          "Giriş yap",
          style: TextStyle(
            fontWeight: FontWeight.w700,
          ),
        ),
      ),
      body: SingleChildScrollView(
        padding: EdgeInsets.all(16),
        child: Form(
          key: _formKey,
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: <Widget>[
              const SizedBox(height: 30),
              Image.asset(
                "assets/logo.png",
                height: 200,
                fit: BoxFit.contain,
              ),
              const SizedBox(height: 30),
              heightBox(20),
              buildTextFormField(
                _tcController,
                "TC",
                "TC gerekli",
                TextInputType.text,
              ),
              heightBox(20),
              _isLoading
                  ? Center(child: CircularProgressIndicator())
                  : ElevatedButton(
                      onPressed: () {
                        if (_formKey.currentState!.validate()) {
                          _checkUser();
                        }
                      },
                      child: const Text("Giriş yap"),
                    ),
              if (_errorMessage.isNotEmpty)
                Padding(
                  padding: const EdgeInsets.only(top: 20),
                  child: Text(
                    _errorMessage,
                    style: TextStyle(color: Colors.red),
                  ),
                ),
              heightBox(20),
            ],
          ),
        ),
      ),
    );
  }

  TextFormField buildTextFormField(TextEditingController controller,
      String label, String errorText, TextInputType textInputType,
      {bool obscureText = false}) {
    return TextFormField(
      controller: controller,
      keyboardType: textInputType,
      decoration: InputDecoration(
        labelText: label,
        errorBorder: const OutlineInputBorder(
          borderSide: BorderSide(width: 1, color: Colors.red),
        ),
        focusedBorder: const OutlineInputBorder(
          borderSide: BorderSide(width: 1, color: Colors.green),
        ),
        focusedErrorBorder: const OutlineInputBorder(
          borderSide: BorderSide(width: 1, color: Colors.green),
        ),
        enabledBorder: const OutlineInputBorder(
          borderSide: BorderSide(width: 1, color: primaryColor),
        ),
      ),
      obscureText: obscureText,
      validator: (value) => value!.isEmpty ? errorText : null,
    );
  }

  SizedBox heightBox(double height) {
    return SizedBox(height: height);
  }
}
