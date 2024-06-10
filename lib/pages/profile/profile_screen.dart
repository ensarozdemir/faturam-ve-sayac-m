import 'package:http/http.dart' as http;
import 'package:qr_code/imports_screens.dart';

class ProfileScreen extends StatefulWidget {
  @override
  _ProfileScreenState createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  bool _isLoading = false;
  Map<String, dynamic>? _userData;

  @override
  void initState() {
    super.initState();
    _fetchUserData();
  }

  Future<void> _fetchUserData() async {
    setState(() {
      _isLoading = true;
    });

    String? tc = await SharedPreferencesService.getUserTc();

    if (tc != null) {
      final response = await http.post(
        Uri.parse('${AppConstant.url}get_user_data.php'),
        headers: <String, String>{
          'Content-Type': 'application/json; charset=UTF-8',
        },
        body: jsonEncode(<String, String>{
          'tc': tc,
        }),
      );

      if (response.statusCode == 200) {
        final Map<String, dynamic> responseData = jsonDecode(response.body);
        setState(() {
          _userData = responseData;
        });
      } else {
        // Handle error
      }
    } else {
      // Handle error: TC not found
    }

    setState(() {
      _isLoading = false;
    });
  }

  Future<void> _logout() async {
    await SharedPreferencesService.logoutUser();
    Navigator.of(context).pushReplacementNamed('/login');
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
          "Profil",
          style: TextStyle(
            fontWeight: FontWeight.w700,
          ),
        ),
      ),
      body: _isLoading
          ? Center(child: CircularProgressIndicator())
          : _userData != null
              ? ListView(
                  physics: const BouncingScrollPhysics(),
                  padding: const EdgeInsets.only(
                    left: fixPadding * 2,
                    right: fixPadding * 2,
                    bottom: fixPadding * 2,
                  ),
                  children: [
                    userProfileDetail(MediaQuery.of(context).size),
                    divider(),
                    listTileWidget(
                        Icons.person,
                        _userData!['username'],
                        Colors.black,
                        () => Navigator.pushNamed(
                            context, AppConstant.terms_and_conditions),
                        true),
                    divider(),
                    listTileWidget(
                        Icons.phone,
                        _userData!['phone'],
                        Colors.black,
                        () => Navigator.pushNamed(
                            context, AppConstant.privacy_policy),
                        true),
                    divider(),
                    listTileWidget(
                      Icons.logout,
                      'Çıkış Yap',
                      Colors.red,
                      _logout,
                      true,
                    ),
                  ],
                )
              : Center(child: Text('No user data found')),
    );
  }

  userProfileDetail(Size size) {
    return Row(
      children: [
        Container(
          height: size.height * 0.08,
          width: size.height * 0.08,
          decoration: const BoxDecoration(
            shape: BoxShape.circle,
            image: DecorationImage(
              image: AssetImage(
                "assets/logo.png",
              ),
              fit: BoxFit.cover,
            ),
          ),
        ),
        widthSpace,
        width5Space,
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                "${_userData!['fullname']}",
                style: bold18Black2,
              ),
              Text(
                _userData!['email'] ?? 'Not set',
                style: semibold14Black2,
              )
            ],
          ),
        )
      ],
    );
  }

  divider() {
    return Container(
      height: 1,
      width: double.maxFinite,
      color: grey94Color.withOpacity(0.3),
    );
  }

  listTileWidget(
      IconData icon, String name, Color color, Function() onTap, bool arrow) {
    return ListTile(
      onTap: onTap,
      minLeadingWidth: 0,
      leading: Icon(
        icon,
        size: 19,
        color: color,
      ),
      title: Text(
        name,
        style: bold15Black2.copyWith(height: 1.1, color: color),
      ),
      // trailing: arrow
      //     ? Icon(
      //         Icons.arrow_forward_ios,
      //         size: 18,
      //         color: color,
      //       )
      //     : null,
    );
  }
}
